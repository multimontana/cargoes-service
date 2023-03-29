<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Common\HttpNotFoundException;
use App\Repositories\User\UserRepository;
use App\Services\Google\GoogleDriveService;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use DomainException;
use Google_Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleAuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;
    /**
     * @var Google_Client
     */
    private Google_Client $client;

    /**
     * @var GoogleDriveService
     */
    private GoogleDriveService $googleDriveService;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;


    public function __construct(
        AuthService        $authService,
        GoogleDriveService $googleDriveService,
        UserRepository     $userRepository
    )
    {
        $this->googleDriveService = $googleDriveService;
        $this->authService = $authService;
        $this->client = $googleDriveService->client();
        $this->userRepository = $userRepository;
    }

    /**
     * @return RedirectResponse
     */
    public function toGoogle(): RedirectResponse
    {
        return $this->authService->toGoogleAuth();
    }

    public function callback(): View
    {

        try {
            $token = $this->authService->createPassportTokenByGoogleId(
                $this->authService->getUserByGoogleAuth()
            );

            return view('post-message/google', [
                'token' => $token,
                'code' => JsonResponse::HTTP_CREATED,
            ]);
        } catch (DomainException $e) {
            return view('post-message/google-error', [
                'message' => $e->getMessage(),
                'code' => JsonResponse::HTTP_CONFLICT,
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed|string|RedirectResponse
     */
    public function handleProviderGoogleCallback(Request $request)
    {
        if ($request->has('code')) {
            $this->client->fetchAccessTokenWithAuthCode($request->input('code'));
            $authCredentials = $this->client->getAccessToken();

            $this->userRepository->update(
                ['google_access_token' => $authCredentials["access_token"]],
                (int)$request->input('state')
            );
            return $this->googleDriveService->getDocumentsInDrive((int)$request->input('state'));
        } else {
            $auth_url = $this->client->createAuthUrl();
            return redirect($auth_url);
        }
    }

    /**
     * @return JsonResponse
     */
    public function googleDriveFiles(): JsonResponse
    {
        return $this->responseJsonOk(
            $this->googleDriveService->getDocumentsInDrive((int)Auth::id())
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws HttpNotFoundException
     */

    public function googleDriveFileExport(Request $request): JsonResponse
    {
        return $this->responseJsonCreated(
            $this->googleDriveService->exportGoogleDocContent($request->all())
        );
    }
}

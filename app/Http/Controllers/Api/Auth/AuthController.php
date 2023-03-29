<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Auth\AuthenticateException;
use App\Http\Controllers\Controller;
use App\Requests\Auth\AuthorizationRequest;
use App\Requests\Auth\ResetPasswordRequest;
use App\Requests\Auth\SendEmailForResetPasswordRequest;
use App\Requests\Auth\SignInWithPasswordRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller implements ISwaggerAuthController
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthorizationRequest $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function authorizationAction(AuthorizationRequest $request): JsonResponse
    {
        return $this->responseJsonCreated(
            $this->authService->authorization($request->all())
        );
    }

    /**
     * @param SignInWithPasswordRequest $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function signInWithPasswordAction(SignInWithPasswordRequest $request): JsonResponse
    {
        return $this->responseJsonCreated(
            $this->authService->signInWithPassword($request->all())
        );
    }

    /**
     * @param SendEmailForResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function sendEmailForResetPasswordAction(SendEmailForResetPasswordRequest $request)
    {
        return $this->responseJsonCreated(
            $this->authService->sendEmailForResetPassword($request->all())
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getResetPasswordDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->authService->getResetPasswordData(
                $this->setQueries($request->query())
            )
        );
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function resetPasswordAction(ResetPasswordRequest $request)
    {
        return $this->responseJsonCreated(
            $this->authService->resetPassword($request->all())
        );
    }

    /**
     * @return JsonResponse
     */
    public function logoutAction(): JsonResponse
    {
        return $this->responseJsonOk(
            $this->authService->logout()
        );
    }
}

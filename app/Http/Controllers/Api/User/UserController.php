<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\Auth\AuthenticateException;
use App\Http\Controllers\Controller;
use App\Services\Country\CountryService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller implements IUserController
{
    /**
     * @vars UserService, UserSimulatorService
     */
    private UserService $userService;
    private CountryService $countryService;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param CountryService $countryService
     */
    public function __construct(
        UserService $userService,
        CountryService $countryService
    ) {
        $this->userService = $userService;
        $this->countryService = $countryService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request): JsonResponse
    {
        $requestData = $this->setRequest($request);
        if ($request->file('image')) {
            $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'profile');
        }
        return $this->responseJsonOk(
            $this->userService->update($requestData)
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->userService->delete(
                $request->user()->id()
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function updatePasswordAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->userService->updatePassword(
                $request->all(),
                $request->user()
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function refreshTokenAction(Request $request): JsonResponse
    {
        return $this->responseJsonCreated(
            $this->userService->refreshToken(
                $request->user()->token
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->userService->getUser()
        );
    }

    /**
     * @return JsonResponse
     */
    public function getCountriesAction(): JsonResponse
    {
        return $this->responseJsonOk(
            $this->countryService->getCountries()
        );
    }
}

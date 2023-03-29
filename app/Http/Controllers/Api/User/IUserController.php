<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\Auth\AuthenticateException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IUserController
{
    /**
     * @OA\Post(
     *     tags={"Пользователь {User}"},
     *     path="/api/v1/user/update",
     *     @OA\Response(response="200", description="Success"),
     *          @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="username", type="string", default="Tony",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="surname", type="string", default="Montana",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="image", type="string", default="montana.svg",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="email", type="string", default="montana@gmail.com",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="blocked", type="string", default="false",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *             )
     *         )
     *      ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Пользователь {User}"},
     *     path="/api/v1/user/delete",
     *     @OA\Response(response="201", description="Success"),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request): JsonResponse;

    /**
     * @OA\Put(
     *     tags={"Пользователь {User}"},
     *     path="/api/v1/user/update/password",
     *     @OA\Response(response="200", description="Success"),
     *          @OA\RequestBody(
     *          description="передаем old_password в том случаи,
     *          если новый пароль был сгенерирован",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="new_password", type="string", default="WTF boy",
     *                  collectionFormat="multi", @OA\Items(type="string"))
     *             )
     *         )
     *      ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function updatePasswordAction(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Пользователь {User}"},
     *     path="/api/v1/user/refresh/token",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearer": {}}}
     * ),
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function refreshTokenAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Пользователь {User}"},
     *     path="/api/v1/user",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearer": {}}}
     * ),
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Пользователь {User}"},
     *     path="/api/v1/countries/get",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearer": {}}}
     * ),
     * @return JsonResponse
     */
    public function getCountriesAction(): JsonResponse;
}

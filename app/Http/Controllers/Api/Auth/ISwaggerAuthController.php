<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Auth\AuthenticateException;
use App\Requests\Auth\AuthorizationRequest;
use App\Requests\Auth\ResetPasswordRequest;
use App\Requests\Auth\SendEmailForResetPasswordRequest;
use App\Requests\Auth\SignInWithPasswordRequest;
use Illuminate\Http\JsonResponse;

interface ISwaggerAuthController
{
    /**
     * @OA\Post(
     *     tags={"Регистрация / Авторизация {SignUp / SignIn}"},
     *     path="/api/v1/authorization",
     *     @OA\RequestBody(
     *          description="после того как получим код активации на почту,
     *          делаем еще один запрос с доп ключем email_code
     *          Пример: {'email': 'test@gmail.com', 'email_code': 'полученный код'}",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  default="test@gmail.com",
     *                  collectionFormat="multi",
     *                  @OA\Items(type="string")),
     *                  required={"email", "confirmed"}
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *      response=201,
     *       description="Created"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *    ),
     *    @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *    ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    )
     * )
     *
     * @param AuthorizationRequest $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function authorizationAction(AuthorizationRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Регистрация / Авторизация {SignUp / SignIn}"},
     *     path="/api/v1/signIn",
     *     @OA\RequestBody(
     *          description="авторизация через пароль",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  default="test@gmail.com",
     *                  collectionFormat="multi",
     *                  @OA\Items(type="string"),
     *                 required={"email", "confirmed"}
     *              ),
     *              @OA\Property(
     *                  property="login_password",
     *                  type="string",
     *                  collectionFormat="multi",
     *                  @OA\Items(type="string"),
     *                 required={"login_password"}
     *              )
     *             ),
     *         )
     *      ),
     *     @OA\Response(
     *      response=201,
     *       description="Created"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *    ),
     *    @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *    ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    )
     * )
     *
     * @param SignInWithPasswordRequest $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function signInWithPasswordAction(SignInWithPasswordRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Регистрация / Авторизация {SignUp / SignIn}"},
     *     path="/api/v1/send/email/for/reset-password",
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  default="test@gmail.com",
     *                  collectionFormat="multi",
     *                  @OA\Items(type="string"),
     *                 required={"email", "confirmed"}
     *              )
     *            ),
     *         )
     *      ),
     *     @OA\Response(
     *      response=201,
     *       description="Created"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *    ),
     *    @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *    ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    )
     * )
     *
     * @param SendEmailForResetPasswordRequest $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function sendEmailForResetPasswordAction(SendEmailForResetPasswordRequest $request);

    /**
     * @OA\Post(
     *     tags={"Регистрация / Авторизация {SignUp / SignIn}"},
     *     path="/api/v1/refresh-password",
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      default="test@gmail.com",
     *                      collectionFormat="multi",
     *                      @OA\Items(type="string"),
     *                      required={"email", "confirmed"}
     *                 ),
     *                  @OA\Property(
     *                      property="signature",
     *                      type="string",
     *                      collectionFormat="multi",
     *                      @OA\Items(type="string"),
     *                      required={"signature"}
     *                  ),
     *                  @OA\Property(
     *                      property="new_password",
     *                      type="string",
     *                      collectionFormat="multi",
     *                      @OA\Items(type="string"),
     *                      required={"new_password"}
     *                  ),
     *            ),
     *         )
     *      ),
     *     @OA\Response(
     *      response=201,
     *       description="Created"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *    ),
     *    @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *    ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    )
     * )
     *
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function resetPasswordAction(ResetPasswordRequest $request);

    /**
     * @OA\Post(
     *     tags={"Регистрация / Авторизация {SignUp / SignIn}"},
     *     path="/api/v1/logout",
     *     @OA\Response(
     *      response=200,
     *       description="Success"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *     security={{"bearer": {}}}
     * )
     */
    public function logoutAction(): JsonResponse;
}

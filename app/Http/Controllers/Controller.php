<?php

namespace App\Http\Controllers;

use App\Traits\Query\QueryHelper;
use App\Traits\Request\AmazonS3Helper;
use App\Traits\Request\RequestDataHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Rescript Swagger REST Api Documentation",
 *      description="Rescript Rest Api Documentation",
 *      @OA\Contact(
 *          email="multitemaa@gmail.com"
 *      )
 * ),
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearer",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use RequestDataHelper;
    use QueryHelper;
    use AmazonS3Helper;

    protected function responseJson(
        $payload = ['message' => 'success'],
        int $code = JsonResponse::HTTP_OK,
        array $headers = [],
        int $options = 0
    ) {
        return response()->json(['data' => $payload], $code, $headers, $options);
    }

    protected function responseJsonOk($payload = ['message' => 'success'])
    {
        return $this->responseJson($payload);
    }

    protected function responseJsonCreated(
        $payload = ['message' => 'success']
    ) {
        return $this->responseJson($payload, JsonResponse::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Api\Bin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IBinController
{
    /**
     * @OA\Get(
     *     tags={"Корзина {Bin}"},
     *     path="/api/v1/bin/get",
     *     @OA\Parameter(
     *         name="language_name",
     *         in="query",
     *         description="выборка по языку, на будущее"
     *     ),
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="поиск по документу на будущее"
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description=""
     *     ),
     *      @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description=""
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="Success"
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
     *    ),
     *    security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getBinDataAction(Request $request): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Корзина {Bin}"},
     *     path="/api/v1/bin/delete/all",
     *     @OA\Response(
     *      response=200,
     *       description="Success"
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
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteBinDataAction(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Корзина {Bin}"},
     *     path="/api/v1/bin/restore",
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
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function restoreBinDataAction(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Корзина {Bin}"},
     *     path="/api/v1/bin/restore/single/entities",
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
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function restoreSingleEntitiesInBinAction(Request $request): JsonResponse;
}

<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IDashboardController
{
    /**
     * @OA\Get(
     *     tags={"Панель {Dashboard}"},
     *     path="/api/v1/dashboard/get/data",
     *     @OA\Parameter(
     *         name="language_name",
     *         in="query",
     *         description="выборка по языку, на будущее"
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="
     *          в параметр передаем deleted
     *          в том случаи если нужно получить удаленные дaнные
     *        ",
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
    public function getDashboardDataAction(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Панель {Dashboard}"},
     *     path="/api/v1/dashboard/pages/how-to-rescript/create",
     *          @OA\RequestBody(
     *          description="Создание данных для страницы",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="main_description", type="string",
     *                  collectionFormat="multi", @OA\Items(type="string"),required={"main_description"}),
     *                  @OA\Property(
     *                  property="video_links", type="string", default={},
     *                  collectionFormat="multi", @OA\Items(type="string"))
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *       response=200,
     *       description="Success"
     *     ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    )
     * ),
     * @param Request $request
     *
     * @return JsonResponse
     */

    public function createHowToRescriptPageDataAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Панель {Dashboard}"},
     *     path="/api/v1/dashboard/pages/how-to-rescript",
     *      @OA\Response(
     *       response=200,
     *       description="Success"
     *     ),
     * ),
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getHowToRescriptPageDataAction(Request $request): JsonResponse;
}

<?php

namespace App\Http\Controllers\Api\Favorite;

use App\Requests\Document\DocumentCreateRequest;
use App\Requests\Favorite\FavoriteCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IFavoriteController
{
    /**
     * @OA\Post(
     *     tags={"Закладки {Favorite}"},
     *     path="/api/v1/favorite/add",
     *          @OA\RequestBody(
     *          description="entity_id может быть уникальным идентификатором для folder или document
     *          entity_type передается для того чтобы система понимала entity_id к какой сущности принадлежит,
     *          document или folder",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Документ Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="entity_id", type="number", default="1",
     *                  collectionFormat="multi", @OA\Items(type="number")),
     *                  @OA\Property(
     *                  property="entity_type", type="string", default="document | folder",
     *                  collectionFormat="multi", @OA\Items(type="string")),
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
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param FavoriteCreateRequest $request
     *
     * @return JsonResponse
     */
    public function addAction(FavoriteCreateRequest $request): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Закладки {Favorite}"},
     *     path="/api/v1/favorite/restore/all",
     *     @OA\Parameter(
     *         description="удалить документ по favoriteId",
     *         in="path",
     *         name="favoriteId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
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
    public function restoreAllAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Закладки {Favorite}"},
     *     path="/api/v1/favorites/get",
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
    public function getFavoritesAction(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Закладки {Favorite}"},
     *     path="/api/v1/favorite/restore/by-entities",
     *          @OA\RequestBody(
     *          description="
     *          folder_id: [] передаем в массив id Папок для восстановления сразу нескольких сущностей
     *          document_id: [] передаем в массив id Документов для восстановления сразу нескольких сущностей
     *          ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="folder_id", type="array", default="[1,2]",
     *                  collectionFormat="multi", @OA\Items(type="string")),
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
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param FavoriteCreateRequest $request
     *
     * @return JsonResponse
     */
    public function restoreSingleEntitiesInFavoriteAction(Request $request): JsonResponse;
}

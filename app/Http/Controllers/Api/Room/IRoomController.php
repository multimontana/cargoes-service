<?php

namespace App\Http\Controllers\Api\Room;

use App\Requests\Project\ProjectRoomCreateRequest;
use App\Requests\Project\ProjectRoomInviteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IRoomController
{
    /**
     * @OA\Post(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/room/create",
     *          @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Комната Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="settings", type="string", default="{}",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="project_id", type="string", default="1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *       response=201,
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
     *    security={{"bearer": {}}}
     * ),
     *
     * @param ProjectRoomCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createAction(ProjectRoomCreateRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/room/update/{roomId}",
     *     @OA\Parameter(
     *         description="обновить комнату по Id",
     *         in="path",
     *         name="roomId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Комната Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string"))
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *       response=200,
     *       description="Updated"
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
     * @param int $roomId
     * @return JsonResponse
     */
    public function updateAction(Request $request, int $roomId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/room/delete/{roomId}",
     *     @OA\Parameter(
     *         description="удалить комнату по Id",
     *         in="path",
     *         name="roomId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="Deleted"
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
     * @param string $roomId
     * @return JsonResponse
     */
    public function deleteAction(Request $request, string $roomId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/room/move/to/bin/{roomId}",
     *     @OA\Parameter(
     *         description="перенос папки в корзину по roomId",
     *         in="path",
     *         name="roomId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="Deleted"
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
     * @param string $roomId
     * @return JsonResponse
     */
    public function moveToBinAction(Request $request, string $roomId): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/room/get/by-room-id/{roomId}",
     *     @OA\Parameter(
     *         description="получить проект по Id",
     *         in="path",
     *         name="roomId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="
     *          в параметр передаем deleted
     *          в том случаи если нужно получить удаленные дaнные
     *        ",
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
     * @param int $roomId
     * @return JsonResponse
     */
    public function getRoomDataByIdAction(Request $request, int $roomId): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/room/send/invite",
     *          @OA\RequestBody(
     *          description="entity_id = уникальный индефикатор комнаты прокта",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email", type="string", default="WTF boy",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="subject", type="string", default="Имя Комнаты",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="entity_id", type="string", default="1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="settings", type="string", default="{edit: true}",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="username", type="string", default="Jackie",
     *                  collectionFormat="multi", @OA\Items(type="string"))
     *             )
     *         )
     *      ),
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
     * @param ProjectRoomInviteRequest $request
     *
     * @return JsonResponse
     */
    public function sendInviteAction(ProjectRoomInviteRequest $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Комната {Room}"},
     *     path="/api/v1/accept/room/invite",
     *      @OA\Response(
     *       response=200,
     *       description="Success"
     *     ),
     * ),
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function acceptInviteAction(Request $request): JsonResponse;
}

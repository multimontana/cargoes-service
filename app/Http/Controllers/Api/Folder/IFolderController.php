<?php

namespace App\Http\Controllers\Api\Folder;

use App\Requests\Folder\FolderCreateRequest;
use App\Requests\Folder\FolderInviteRequest;
use App\Requests\Folder\FolderUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IFolderController
{
    /**
     * @OA\Post(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folder/create",
     *          @OA\RequestBody(
     *          description="room_id или project_id передаем в том случаи
     *        , если папку нужно присвоить к комнате или к проекту",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Проект Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="user_id", type="string", default="1",
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
     * @param FolderCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createAction(FolderCreateRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folder/update/{folderId}",
     *     @OA\Parameter(
     *         description="обновить папку по Id",
     *         in="path",
     *         name="folderId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          description="project_room_id передаем в том случаи, если папку нужно присвоить к комнате",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Файл Н 1",
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
     * @param FolderUpdateRequest $request
     *
     * @param int $folderId
     * @return JsonResponse
     */
    public function updateAction(FolderUpdateRequest $request, int $folderId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folder/delete/{folderId}",
     *     @OA\Parameter(
     *         description="удалить папку по Id",
     *         in="path",
     *         name="folderId",
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
     * @param int $folderId
     * @return JsonResponse
     */
    public function deleteAction(Request $request, string $folderId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folder/move/to/bin/{folderId}",
     *     @OA\Parameter(
     *         description="перенос папки в корзину по folderId",
     *         in="path",
     *         name="folderId",
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
     * @param string $folderId
     * @return JsonResponse
     */
    public function moveToBinAction(Request $request, string $folderId): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folders/get",
     *     @OA\Parameter(
     *         name="language_name",
     *         in="query",
     *         description="выборка по языку, на будущее"
     *     ),
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="поиск по проекту на будущее"
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFoldersAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folder/get/by-folder-id/{folderId}",
     *     @OA\Parameter(
     *         description="получить папку по Id",
     *         in="path",
     *         name="folderId",
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
     * @param int $folderId
     * @return JsonResponse
     */
    public function getFolderDataByIdAction(Request $request, int $folderId): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/folder/send/invite",
     *          @OA\RequestBody(
     *          description="entity_id = уникальный индефикатор папки",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email", type="string", default="WTF boy",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="subject", type="string", default="Имя Папки",
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
     * @param FolderInviteRequest $request
     *
     * @return JsonResponse
     */
    public function sendInviteAction(FolderInviteRequest $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Папка {Folder}"},
     *     path="/api/v1/accept/folder/invite",
     *     @OA\Response(
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

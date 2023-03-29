<?php

namespace App\Http\Controllers\Api\Document;

use App\Requests\Document\DocumentByIdRequest;
use App\Requests\Document\DocumentCreateRequest;
use App\Requests\Document\DocumentInviteRequest;
use App\Requests\Document\DocumentLinkInviteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IDocumentController
{
    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/create",
     *          @OA\RequestBody(
     *          description="folder_id, project_id, room_id передаем в том случаи,
     *          если нужно документ присвоить к папке, комнате или к проекту",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Документ Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="user_id", type="string", default="1",
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
     * @param DocumentCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createAction(DocumentCreateRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/update/{documentId}",
     *     @OA\Parameter(
     *         description="обновить документ по Id",
     *         in="path",
     *         name="documentId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          description="folder_id передаем в том случаи, если нужно документ присвоить к папке",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Документ Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string"))
     *             )
     *         )
     *      ),
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
     * @param int $documentId
     * @return JsonResponse
     */
    public function updateAction(Request $request, int $documentId): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/user/update/{documentId}",
     *     @OA\Parameter(
     *         description="обновить документ юзера по Id",
     *         in="path",
     *         name="documentId",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          description="folder_id передаем в том случаи, если нужно документ присвоить к папке",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="user_id", type="integer", default=1,
     *                  collectionFormat="multi", @OA\Items(type="string"), required={"entity_id"}),
     *                  @OA\Property(
     *                  property="settings", type="string", default="{}",
     *                  collectionFormat="multi", @OA\Items(type="string"), required={"settings"})
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *      response=200,
     *       description="Success"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     * @param string $documentId
     * @return JsonResponse
     */
    public function updateDocumentUserPermissionAction(Request $request, string $documentId): JsonResponse;
    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/user/delete/{documentId}",
     *     @OA\Parameter(
     *         description="Удалить юзера из документа по Id",
     *         in="path",
     *         name="documentId",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          description="Удаление юзезра из документа",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="user_id", type="integer", default=1,
     *                  collectionFormat="multi", @OA\Items(type="string"), required={"user_id"})
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *      response=200,
     *       description="Success"
     *     ),
     *     @OA\Response(
     *      response=403,
     *       description="Forbidden"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    ),
     *     security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     * @param string $documentId
     * @return JsonResponse
     */
    public function deleteDocumentUserAction(Request $request, string $documentId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/delete/{documentId}",
     *     @OA\Parameter(
     *         description="удалить документ по documentId",
     *         in="path",
     *         name="documentId",
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
     * @param string $documentId
     * @return JsonResponse
     */
    public function deleteAction(Request $request, string $documentId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/move/to/bin/{documentId}",
     *     @OA\Parameter(
     *         description="перенос документа в корзину по documentId",
     *         in="path",
     *         name="documentId",
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
     * @param string $documentId
     * @return JsonResponse
     */
    public function moveToBinAction(Request $request, string $documentId): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/documents/get",
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
    public function getDocumentsAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/get/by-document-id/{documentId}",
     *     @OA\Parameter(
     *         description="получить документ по Id",
     *         in="path",
     *         name="documentId",
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
     *      ),
     *      @OA\Response(
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
     *   security={{"bearer": {}}},
     * ),
     *
     * @param DocumentByIdRequest $request
     * @param int $documentId
     * @return JsonResponse
     */
    public function getDocumentByIdAction(DocumentByIdRequest $request, int $documentId): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/send/invite",
     *          @OA\RequestBody(
     *          description="entity_id = уникальный индефикатор документа",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email", type="string", default="WTF boy",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="subject", type="string", default="Имя Документа",
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
     *     security={{"bearer": {}}}
     * ),
     * @param DocumentInviteRequest $request
     *
     * @return JsonResponse
     */
    public function sendInviteAction(DocumentInviteRequest $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/accept/document/invite",
     *     @OA\Response(
     *       response=200,
     *       description="Success"
     *     ),
     * ),
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function acceptInviteAction(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/copy-link/invite",
     *          @OA\RequestBody(
     *          description="entity_id = уникальный индефикатор документа",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="entity_id", type="int", default=1,
     *                  collectionFormat="multi", @OA\Items(type="string"),required={"entity_id"})
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
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    ),
     *     security={{"bearer": {}}}
     * ),
     * @param Request $request
     *
     * @return JsonResponse
     */

    public function inviteCopyLinkAction(Request $request): JsonResponse;
    /**
     * @OA\Post(
     *     tags={"Документ {Document}"},
     *     path="/api/v1/document/accept/copy-link/invite",
     *          @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="token", type="string",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="user_id", type="integer",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="settings", type="string", default="{}",
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
     *    @OA\Response(
     *      response=500,
     *      description="Internal Server Error"
     *    ),
     *     security={{"bearer": {}}}
     * ),
     * @param DocumentLinkInviteRequest $request
     *
     * @return JsonResponse
     */

    public function acceptLinkInviteAction(DocumentLinkInviteRequest $request): JsonResponse;
}

<?php

namespace App\Http\Controllers\Api\Project;

use App\Requests\Project\ProjectCreateRequest;
use App\Requests\Project\ProjectInviteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IProjectController
{
    /**
     * @OA\Post(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/create",
     *          @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="name", type="string", default="Проект Н 1",
     *                  collectionFormat="multi", @OA\Items(type="string"))
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
     * @param ProjectCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createAction(ProjectCreateRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/update/{projectId}",
     *     @OA\Parameter(
     *         description="обновить проект по Id",
     *         in="path",
     *         name="projectId",
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
     *                  property="name", type="string", default="Проект Н 1",
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
     * @param int $projectId
     * @return JsonResponse
     */
    public function updateAction(Request $request, int $projectId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/delete/{projectId}",
     *     @OA\Parameter(
     *         description="удалить проект по Id",
     *         in="path",
     *         name="projectId",
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
     * @param string $projectId
     * @return JsonResponse
     */
    public function deleteAction(Request $request, string $projectId): JsonResponse;

    /**
     * @OA\Delete(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/move/to/bin/{projectId}",
     *     @OA\Parameter(
     *         description="перенос папки в корзину по projectId",
     *         in="path",
     *         name="projectId",
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
     * @param string $projectId
     * @return JsonResponse
     */
    public function moveToBinAction(Request $request, string $projectId): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/projects/get",
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
     *         description="поиск по проекту на будущее"
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
    public function getProjectsAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/get/by-project-id/{projectId}",
     *     @OA\Parameter(
     *         description="получить проект по Id",
     *         in="path",
     *         name="projectId",
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
     * @param int $projectId
     *
     * @return JsonResponse
     */
    public function getProjectDataByIdAction(Request $request, int $projectId): JsonResponse;

    /**
     * @OA\Post(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/send/invite",
     *          @OA\RequestBody(
     *          description="entity_id = уникальный индефикатор проекта",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="email", type="string", default="WTF boy",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="subject", type="string", default="Имя Проекта",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="entity_id", type="string", default="1",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="settings", type="string", default="{edit: true}",
     *                  collectionFormat="multi", @OA\Items(type="string")),
     *                  @OA\Property(
     *                  property="role", type="string", default="Member",
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
     * @param ProjectInviteRequest $request
     *
     * @return JsonResponse
     */
    public function sendInviteAction(ProjectInviteRequest $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/accept/project/invite",
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
     * @return JsonResponse
     */
    public function acceptInviteAction(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     tags={"Проект {Project}"},
     *     path="/api/v1/project/get/members/{projectId}",
     *     @OA\Parameter(
     *         description="получить члены проектa по Id",
     *         in="path",
     *         name="projectId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="Success"
     *     ),
     *     @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *     ),
     *    @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *    ),
     *    security={{"bearer": {}}}
     * ),
     *
     * @param Request $request
     * @param int $projectId
     * @return JsonResponse
     */
    public function getProjectMembersAction(Request $request, int $projectId): JsonResponse;
}

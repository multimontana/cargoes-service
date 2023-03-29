<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Requests\Project\ProjectCreateRequest;
use App\Requests\Project\ProjectInviteRequest;
use App\Services\Project\ProjectService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller implements IProjectController
{
    /**
     * @vars ProjectService
     */
    private ProjectService $projectService;

    /**
     * ProjectController constructor.
     *
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @param ProjectCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createAction(ProjectCreateRequest $request): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'project');

        return $this->responseJsonCreated(
            $this->projectService->create($requestData)
        );
    }

    /**
     * @param Request $request
     * @param int $projectId
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, int $projectId): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'project');

        return $this->responseJsonOk(
            $this->projectService->update($requestData, $projectId)
        );
    }

    /**
     * @param Request $request
     * @param string $projectId
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function moveToBinAction(Request $request, string $projectId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->projectService->moveToBin(
                $this->setRequest($request),
                $projectId
            )
        );
    }

    /**
     * @param Request $request
     * @param string $projectId
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function deleteAction(Request $request, string $projectId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->projectService->delete(
                $this->setRequest($request),
                $projectId
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getProjectsAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->projectService->getProjects(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     * @param int $projectId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function getProjectDataByIdAction(Request $request, int $projectId): JsonResponse
    {
        return $this->responseJson(
            $this->projectService->getProjectDataById(
                $this->setRequest($request),
                $projectId
            ),
            $data->code ?? JsonResponse::HTTP_OK
        );
    }

    /**
     * @param ProjectInviteRequest $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function sendInviteAction(ProjectInviteRequest $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->projectService->sendInvite(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProjectMembersAction(Request $request, int $projectId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->projectService->getProjectMembers(
                $this->setRequest($request),
                $projectId
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Auth\AuthenticateException
     */
    public function acceptInviteAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->projectService->acceptInvite(
                $this->setQueries($request->query())
            )
        );
    }
}

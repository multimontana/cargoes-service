<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use App\Requests\Folder\FolderCreateRequest;
use App\Requests\Folder\FolderInviteRequest;
use App\Requests\Folder\FolderUpdateRequest;
use App\Services\Folder\FolderService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FolderController extends Controller implements IFolderController
{
    /**
     * @vars FolderService
     */
    private FolderService $folderService;

    /**
     * FileController constructor.
     *
     * @param FolderService $folderService
     */
    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }

    /**
     * @param FolderCreateRequest $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\UnprocessableEntityException
     */
    public function createAction(FolderCreateRequest $request): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'folder');

        return $this->responseJsonOk(
            $this->folderService->create($requestData)
        );
    }

    /**
     * @param FolderUpdateRequest $request
     * @param int $folderId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\UnprocessableEntityException
     */
    public function updateAction(FolderUpdateRequest $request, int $folderId): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'folder');

        return $this->responseJsonOk(
            $this->folderService->update($requestData, $folderId)
        );
    }

    /**
     * @param Request $request
     * @param string $folderIds
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function moveToBinAction(Request $request, string $folderIds): JsonResponse
    {
        return $this->responseJsonOk(
            $this->folderService->moveToBin(
                $this->setRequest($request),
                $folderIds
            )
        );
    }

    /**
     * @param Request $request
     * @param string $folderId
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function deleteAction(Request $request, string $folderId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->folderService->delete(
                $this->setRequest($request),
                $folderId
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFoldersAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->folderService->getFolders(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     * @param int $folderId
     *
     * @return JsonResponse
     */
    public function getFolderDataByIdAction(Request $request, int $folderId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->folderService->getFolderDataById(
                $this->setRequest($request),
                $folderId
            )
        );
    }

    /**
     * @param FolderInviteRequest $request
     *
     * @return JsonResponse
     */
    public function sendInviteAction(FolderInviteRequest $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->folderService->sendInvite(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function acceptInviteAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->folderService->acceptInvite(
                $this->setQueries($request->query())
            )
        );
    }
}

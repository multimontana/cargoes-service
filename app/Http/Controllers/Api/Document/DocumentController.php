<?php

namespace App\Http\Controllers\Api\Document;

use App\Exceptions\Auth\AuthenticateException;
use App\Http\Controllers\Controller;
use App\Requests\Document\DocumentByIdRequest;
use App\Requests\Document\DocumentCreateRequest;
use App\Requests\Document\DocumentInviteRequest;
use App\Requests\Document\DocumentLinkInviteRequest;
use App\Services\Document\DocumentService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentController extends Controller implements IDocumentController
{
    /**
     * @vars DocumentService
     */
    private DocumentService $documentService;

    /**
     * DocumentController constructor.
     *
     * @param DocumentService $documentService
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @param DocumentCreateRequest $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\UnprocessableEntityException
     */
    public function createAction(DocumentCreateRequest $request): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'document');

        return $this->responseJsonCreated(
            $this->documentService->create($requestData)
        );
    }

    /**
     * @param Request $request
     * @param int $documentId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\PermissionDeniedException
     * @throws \App\Exceptions\Common\UnprocessableEntityException
     */
    public function updateAction(Request $request, int $documentId): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'document');

        return $this->responseJsonOk(
            $this->documentService->update($requestData, $documentId)
        );
    }

    /**
     * @param Request $request
     * @param string $documentId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function updateDocumentUserPermissionAction(Request $request, string $documentId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->updateUserPermissions(
                $this->setRequest($request),
                $documentId
            )
        );
    }


    /**
     * @param Request $request
     * @param string $documentId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function deleteDocumentUserAction(Request $request, string $documentId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->deleteDocumentUser(
                $this->setRequest($request),
                $documentId
            )
        );
    }


    /**
     * @param Request $request
     * @param string $documentId
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function moveToBinAction(Request $request, string $documentId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->moveToBin(
                $this->setRequest($request),
                $documentId
            )
        );
    }

    /**
     * @param Request $request
     * @param string $documentId
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function deleteAction(Request $request, string $documentId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->delete(
                $this->setRequest($request),
                $documentId
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getDocumentsAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->getDocuments(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param DocumentByIdRequest $request
     * @param int $documentId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function getDocumentByIdAction(DocumentByIdRequest $request, int $documentId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->getDocumentById(
                $this->setRequest($request),
                $documentId
            )
        );
    }

    /**
     * @param DocumentInviteRequest $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function sendInviteAction(DocumentInviteRequest $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->sendInvite(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function inviteCopyLinkAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->generateCopyLink(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param DocumentLinkInviteRequest $request
     *
     * @return JsonResponse
     */
    public function acceptLinkInviteAction(DocumentLinkInviteRequest $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->acceptLinkInvite(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws AuthenticateException
     */
    public function acceptInviteAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->documentService->acceptInvite(
                $this->setQueries($request->query())
            )
        );
    }
}

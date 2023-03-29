<?php

namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\Controller;
use App\Requests\Project\ProjectRoomCreateRequest;
use App\Requests\Project\ProjectRoomInviteRequest;
use App\Services\Room\RoomService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller implements IRoomController
{
    /**
     * @vars RoomService
     */
    private RoomService $roomService;

    /**
     * RoomController constructor.
     *
     * @param RoomService $roomService
     */
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * @param ProjectRoomCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createAction(ProjectRoomCreateRequest $request): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'room');

        return $this->responseJsonCreated(
            $this->roomService->create($requestData)
        );
    }

    /**
     * @param Request $request
     * @param int $roomId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\UnprocessableEntityException
     */
    public function updateAction(Request $request, int $roomId): JsonResponse
    {
        $requestData = $this->setRequest($request);
        $requestData['body']['image'] = $this->uploadImageFromAmazon($request, 'image', 'room');

        return $this->responseJsonOk(
            $this->roomService->update($requestData, $roomId)
        );
    }

    /**
     * @param Request $request
     * @param string $roomId
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function moveToBinAction(Request $request, string $roomId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->roomService->moveToBin(
                $this->setRequest($request),
                $roomId
            )
        );
    }

    /**
     * @param Request $request
     * @param string $roomId
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function deleteAction(Request $request, string $roomId): JsonResponse
    {
        return $this->responseJsonOk(
            $this->roomService->delete(
                $this->setRequest($request),
                $roomId
            )
        );
    }

    /**
     * @param Request $request
     * @param int $roomId
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\HttpNotFoundException
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function getRoomDataByIdAction(Request $request, int $roomId): JsonResponse
    {
        return $this->responseJson(
            $this->roomService->getRoomDataById(
                $this->setRequest($request),
                $roomId
            ),
            $data->code ?? JsonResponse::HTTP_OK
        );
    }

    /**
     * @param ProjectRoomInviteRequest $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\Common\PermissionDeniedException
     */
    public function sendInviteAction(ProjectRoomInviteRequest $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->roomService->sendInvite(
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
            $this->roomService->acceptInvite(
                $this->setQueries($request->query())
            )
        );
    }
}

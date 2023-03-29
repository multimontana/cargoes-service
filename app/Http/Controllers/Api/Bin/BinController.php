<?php

namespace App\Http\Controllers\Api\Bin;

use App\Http\Controllers\Controller;
use App\Services\Bin\BinService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BinController extends Controller implements IBinController
{
    /**
     * @vars BinService
     */
    private BinService $binService;

    /**
     * RoomController constructor.
     *
     * @param BinService $binService
     */
    public function __construct(BinService $binService)
    {
        $this->binService = $binService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function getBinDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->binService->getBinData(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteBinDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->binService->deleteBinData(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function restoreBinDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->binService->restoreBinData(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function restoreSingleEntitiesInBinAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->binService->restoreSingleEntitiesInBin(
                $this->setRequest($request)
            )
        );
    }
}

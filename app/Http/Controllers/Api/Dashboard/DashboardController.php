<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller implements IDashboardController
{
    /**
     * @vars DashboardService
     */
    private DashboardService $dashboardService;

    /**
     * DashboardController constructor.
     *
     * @param DashboardService $dashboardService
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getDashboardDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->dashboardService->getDashboardData(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getHowToRescriptPageDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->dashboardService->getHowToRescriptDataAction()
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createHowToRescriptPageDataAction(Request $request): JsonResponse
    {
        return $this->responseJsonCreated(
            $this->dashboardService->createHowToRescriptDataAction(
                $request->all()
            )
        );
    }
}

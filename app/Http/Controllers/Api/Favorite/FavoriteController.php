<?php

namespace App\Http\Controllers\Api\Favorite;

use App\Http\Controllers\Controller;
use App\Requests\Favorite\FavoriteCreateRequest;
use App\Services\Favorite\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller implements IFavoriteController
{
    /**
     * @vars FavoriteService
     */
    private FavoriteService $favoriteService;

    /**
     * DocumentController constructor.
     *
     * @param FavoriteService $favoriteService
     */
    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * @param FavoriteCreateRequest $request
     *
     * @return JsonResponse
     */
    public function addAction(FavoriteCreateRequest $request): JsonResponse
    {
        return $this->responseJsonCreated(
            $this->favoriteService->add(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function restoreAllAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->favoriteService->restoreAll(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFavoritesAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->favoriteService->getFavorites(
                $this->setRequest($request)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function restoreSingleEntitiesInFavoriteAction(Request $request): JsonResponse
    {
        return $this->responseJsonOk(
            $this->favoriteService->restoreSingleEntitiesInFavorite(
                $this->setRequest($request)
            )
        );
    }
}

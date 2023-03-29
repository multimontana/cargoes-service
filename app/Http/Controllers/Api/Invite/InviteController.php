<?php

namespace App\Http\Controllers\Api\Invite;

use App\Http\Controllers\Controller;
use App\Services\Project\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InviteController extends Controller implements IInviteController
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
}

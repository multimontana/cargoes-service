<?php

namespace App\Repositories\User;

use App\Entity\UserPackages\UserProject;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserProjectRepository extends AbstractRepository
{
    /**
     * ProjectUserRepository constructor.
     */
    public function __construct()
    {
        $this->model = new UserProject();
    }
}

<?php

namespace App\Repositories\User;

use App\Entity\UserPackages\UserFolder;
use App\Repositories\AbstractRepository;

class UserFolderRepository extends AbstractRepository
{
    /**
     * UserFolderRepository constructor.
     */
    public function __construct()
    {
        $this->model = new UserFolder();
    }
}

<?php

namespace App\Repositories\User;

use App\Entity\UserPackages\UserRoom;
use App\Repositories\AbstractRepository;

class UserRoomRepository extends AbstractRepository
{
    /**
     * UserRoomRepository constructor.
     */
    public function __construct()
    {
        $this->model = new UserRoom();
    }
}

<?php

namespace App\Services\User;

use App\Interfaces\Invite\ISystemInviteEntity;
use App\Repositories\User\UserRoomRepository;
use Illuminate\Database\Eloquent\Model;

class UserRoomService implements ISystemInviteEntity
{
    /**
     * @var UserRoomRepository
     */
    private UserRoomRepository $userRoomRepository;

    /**
     * ProjectService constructor.
     *
     * @param UserRoomRepository $userRoomRepository
     */
    public function __construct(UserRoomRepository $userRoomRepository)
    {
        $this->userRoomRepository = $userRoomRepository;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): ?Model
    {
        return $this->userRoomRepository
            ->create($data['body']);
    }

    /**
     * @param array $options
     * @param array $data
     * @return Model
     */
    public function updateOrCreate(array $options, array $data): Model
    {
        return $this->userRoomRepository
            ->updateOrCreate($options, $data['body']);
    }
}

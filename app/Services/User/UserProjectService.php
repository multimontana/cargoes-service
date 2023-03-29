<?php

namespace App\Services\User;

use App\Interfaces\Invite\ISystemInviteEntity;
use App\Repositories\User\UserProjectRepository;
use Illuminate\Database\Eloquent\Model;

class UserProjectService implements ISystemInviteEntity
{
    /**
     * @var UserProjectRepository
     */
    private UserProjectRepository $userProjectRepository;

    /**
     * ProjectService constructor.
     *
     * @param UserProjectRepository $userProjectRepository
     */
    public function __construct(UserProjectRepository $userProjectRepository)
    {
        $this->userProjectRepository = $userProjectRepository;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): ?Model
    {
        return $this->userProjectRepository
            ->create($data['body']);
    }

    /**
     * @param array $options
     * @param array $data
     * @return Model
     */
    public function updateOrCreate(array $options, array $data): Model
    {
        return $this->userProjectRepository
            ->updateOrCreate($options, $data['body']);
    }
}

<?php

namespace App\Services\User;

use App\Interfaces\Invite\ISystemInviteEntity;
use App\Repositories\User\UserFolderRepository;
use Illuminate\Database\Eloquent\Model;

class UserFolderService implements ISystemInviteEntity
{
    /**
     * @var UserFolderRepository
     */
    private UserFolderRepository $userFolderRepository;

    /**
     * ProjectService constructor.
     *
     * @param UserFolderRepository $userFolderRepository
     */
    public function __construct(UserFolderRepository $userFolderRepository)
    {
        $this->userFolderRepository = $userFolderRepository;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): ?Model
    {
        return $this->userFolderRepository
            ->create($data['body']);
    }

    /**
     * @param array $options
     * @param array $data
     * @return Model
     */
    public function updateOrCreate(array $options, array $data): Model
    {
        return $this->userFolderRepository
            ->updateOrCreate($options, $data['body']);
    }
}

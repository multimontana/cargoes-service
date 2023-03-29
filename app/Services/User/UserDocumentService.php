<?php

namespace App\Services\User;

use App\Interfaces\Invite\ISystemInviteEntity;
use App\Repositories\User\UserDocumentRepository;
use Illuminate\Database\Eloquent\Model;

class UserDocumentService implements ISystemInviteEntity
{
    /**
     * @vars UserDocumentRepository
     */
    private UserDocumentRepository $userDocumentRepository;

    /**
     * UserDocumentService constructor.
     *
     * @param UserDocumentRepository $userDocumentRepository
     */
    public function __construct(
        UserDocumentRepository $userDocumentRepository
    ) {
        $this->userDocumentRepository = $userDocumentRepository;
    }

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        return $this->userDocumentRepository
            ->create($data['body']);
    }

    /**
     * @param array $options
     * @param array $data
     *
     * @return Model|null
     */
    public function updateOrCreate(array $options, array $data): ?Model
    {
        return $this->userDocumentRepository
            ->updateOrCreate($options, $data);
    }
}

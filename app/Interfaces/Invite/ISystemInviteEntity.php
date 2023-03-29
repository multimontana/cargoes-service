<?php

namespace App\Interfaces\Invite;

use Illuminate\Database\Eloquent\Model;

interface ISystemInviteEntity
{
    /**
     * @param array $options
     * @param array $data
     *
     * @return Model|null
     */
    public function updateOrCreate(array $options, array $data): ?Model;
}

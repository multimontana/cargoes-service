<?php

namespace App\Repositories\User;

use App\Entity\UserPackages\PasswordReset;
use App\Repositories\AbstractRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class PasswordResetRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->model = new PasswordReset();
    }
}

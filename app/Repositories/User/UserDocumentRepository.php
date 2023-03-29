<?php

namespace App\Repositories\User;

use App\Entity\UserPackages\UserDocument;
use App\Repositories\AbstractRepository;

class UserDocumentRepository extends AbstractRepository
{
    /**
     * UserDocumentRepository constructor.
     */
    public function __construct()
    {
        $this->model = new UserDocument();
    }
}

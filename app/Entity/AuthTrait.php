<?php

namespace App\Entity;

trait AuthTrait
{
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }
}

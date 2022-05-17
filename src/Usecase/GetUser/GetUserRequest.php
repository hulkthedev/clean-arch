<?php

namespace App\Usecase\GetUser;

class GetUserRequest
{
    public int $userId;

    /**
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}

<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\Exception\DatabaseException;
use App\Repository\RepositoryInterface;
use App\Usecase\ResultCodes;

class MariaDbRepositoryStub implements RepositoryInterface
{
    private bool $throwException;

    public function __construct(bool $throwException = false)
    {
        $this->throwException = $throwException;
    }

    /**
     * @inheritDoc
     */
    public function addUser(User $user): int
    {
        if ($this->throwException) {
            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_SAVED);
        }

        return 1000;
    }

    /**
     * @inheritDoc
     */
    public function getUserById(int $userId): array
    {
        if ($this->throwException) {
            throw new DatabaseException(ResultCodes::USER_NOT_FOUND);
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function deleteUserById(int $userId): bool
    {
        if ($this->throwException) {
            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_DELETED);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function updateUserById(User $user): bool
    {
        if ($this->throwException) {
            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_UPDATED);
        }

        return true;
    }
}

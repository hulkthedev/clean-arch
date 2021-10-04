<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use Exception;

interface RepositoryInterface
{
    /**
     * @return bool
     * @throws DatabaseException
     */
    public function addUser(): bool;

    /**
     * @param int $userId
     * @return array
     * @throws DatabaseException
     * @throws Exception
     */
    public function getUserById(int $userId): array;

    /**
     * @param int $userId
     * @return bool
     * @throws DatabaseException
     */
    public function deleteUserById(int $userId): bool;

    /**
     * @param int $userId
     * @return bool
     * @throws DatabaseException
     */
    public function updateUserById(int $userId): bool;
}

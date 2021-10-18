<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Exception\DatabaseException;

interface RepositoryInterface
{
    /**
     * @param User $user
     * @return int
     * @throws DatabaseException
     */
    public function addUser(User $user): int;

    /**
     * @param int $contractId
     * @return array
     * @throws DatabaseException
     */
    public function getContractById(int $contractId): array;

    /**
     * @param int $userId
     * @return bool
     * @throws DatabaseException
     */
    public function deleteUserById(int $userId): bool;

    /**
     * @param User $user
     * @return bool
     * @throws DatabaseException
     */
    public function updateUserById(User $user): bool;
}

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
     * @param int $contractNumber
     * @return array
     * @throws DatabaseException
     */
    public function getContractByNumber(int $contractNumber): array;

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

<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;

interface RepositoryInterface
{
    /**
     * @param int $contractNumber
     * @param bool $ignoreObjects
     * @return Contract
     * @throws DatabaseUnreachableException
     * @throws ContractNotFoundException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
     */
    public function getContractByNumber(int $contractNumber, bool $ignoreObjects = false): Contract;

    /**
     * @param int $contractNumber
     * @return bool
     * @throws DatabaseUnreachableException
     * @throws ContractNotFoundException
     */
    public function terminateContractByNumber(int $contractNumber): bool;
}

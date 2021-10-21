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
     * @return Contract
     * @throws DatabaseUnreachableException
     * @throws ContractNotFoundException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
     */
    public function getContractByNumber(int $contractNumber): Contract;

}

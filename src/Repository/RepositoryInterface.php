<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Repository\Exception\ContractCanNotBeTerminatedException;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BookRisk\Exception\RiskCanNotBeBookedException;

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
     * @param string $date
     * @return bool
     * @throws DatabaseUnreachableException
     * @throws ContractCanNotBeTerminatedException
     */
    public function terminateContractByNumber(int $contractNumber, string $date): bool;

    /**
     * @param int $objectId
     * @param int $riskType
     * @return bool
     * @throws DatabaseUnreachableException
     * @throws RiskCanNotBeBookedException
     */
    public function bookRisk(int $objectId, int $riskType): bool;
}

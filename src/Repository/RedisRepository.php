<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Mapper\RedisMapper as Mapper;
use App\Repository\Exception\ContractCanNotBeTerminatedException;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BookRisk\Exception\RiskCanNotBeBookedException;

class RedisRepository implements RepositoryInterface
{
    private Mapper $mapper;

    /**
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function getContractByNumber(int $contractNumber, bool $ignoreObjects = false): Contract
    {

    }

    /**
     * @inheritDoc
     */
    public function terminateContractByNumber(int $contractNumber, string $date): bool
    {

    }

    /**
     * @inheritDoc
     */
    public function bookRisk(int $objectId, int $riskType): bool
    {

    }
}

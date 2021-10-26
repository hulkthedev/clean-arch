<?php

namespace App\Tests\Repository;

use App\Entity\Contract;
use App\Repository\Exception\ContractCanNotBeTerminatedException;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\RepositoryInterface;
use App\Tests\Entity\ContractStub;
use App\Usecase\BookRisk\Exception\RiskCanNotBeBookedException;
use App\Usecase\ResultCodes;

class MariaDbRepositoryStub implements RepositoryInterface
{
    private array $throwException;

    /**
     * @param array $throwException
     */
    public function __construct(array $throwException = [])
    {
        $this->throwException = $throwException;
    }

    /**
     * @inheritDoc
     */
    public function getContractByNumber(int $contractNumber, bool $ignoreObjects = false): Contract
    {
        if ($this->throwException[__FUNCTION__]) {
            throw new ContractNotFoundException();
        }

        return new ContractStub();
    }

    /**
     * @inheritDoc
     */
    public function terminateContractByNumber(int $contractNumber, string $date): bool
    {
        if ($this->throwException[__FUNCTION__]) {
            throw new ContractCanNotBeTerminatedException();
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function bookRisk(int $objectId, int $riskType): bool
    {
        if ($this->throwException[__FUNCTION__]) {
            throw new RiskCanNotBeBookedException(ResultCodes::RISK_TYPE_ERROR);
        }

        return true;
    }
}

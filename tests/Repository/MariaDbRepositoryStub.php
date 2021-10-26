<?php

namespace App\Tests\Repository;

use App\Entity\Contract;
use App\Repository\Exception\ContractCanNotBeTerminatedException;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\RepositoryInterface;
use App\Tests\Entity\ContractStub;

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
}

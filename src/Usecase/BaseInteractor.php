<?php

namespace App\Usecase;

use App\Entity\Contract;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Repository\RedisRepository;
use App\Repository\RepositoryInterface as Repository;
use App\Usecase\Exception\BadRequestException;
use App\Usecase\Exception\DeclineByContractException;
use App\Usecase\Exception\MissingParameterException;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseInteractor
{
    private RedisRepository $repository;
    protected Contract $contract;

    /**
     * @param RedisRepository $repository
     */
    public function __construct(RedisRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     */
    abstract protected function validateRequest(Request $request): void;

    /**
     * @return RedisRepository
     */
    protected function getRepository(): RedisRepository
    {
        return $this->repository;
    }

    /**
     * @param Request $request
     * @param array $params
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    protected function validateParameter(Request $request, array $params): void
    {
        foreach ($params as $param) {
            if (null === $request->get($param)) {
                throw new BadRequestException();
            }

            if ((int)$request->get($param) === 0) {
                throw new MissingParameterException();
            }
        }
    }

    /**
     * @param int $contractNumber
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws DeclineByContractException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
     */
    protected function validateContract(int $contractNumber): void
    {
        /**
         * @note this is a stateless example.
         * $contracts should be read from the session or other cache layer, not from the database.
         */
        $this->contract = $this->getRepository()->getContractByNumber($contractNumber);

        if ($this->contract->isInactive()) {
            throw new DeclineByContractException(ResultCodes::CONTRACT_ALREADY_INACTIVE);
        }

        if ($this->contract->isTerminated()) {
            throw new DeclineByContractException(ResultCodes::CONTRACT_ALREADY_TERMINATED);
        }

        if ($this->contract->isFinished()) {
            throw new DeclineByContractException(ResultCodes::CONTRACT_ALREADY_FINISHED);
        }
    }
}

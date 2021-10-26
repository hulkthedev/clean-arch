<?php

namespace App\Usecase\TerminateContract;

use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\Exception\BadRequestException;
use App\Usecase\Exception\MissingParameterException;
use App\Usecase\ResultCodes;
use App\Usecase\TerminateContract\Exception\ContractCanNotBeTerminatedException;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class TerminateContractInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS;

        try {
            $this->validateRequest($request);
            $this->getRepository()->terminateContractByNumber((int)$request->get('contractNumber'), $request->get('toDate'));
        } catch (Throwable $exception) {
            $code = $exception->getCode();
        }

        return new BaseResponse($code);
    }

    /**
     * @param Request $request
     * @throws ContractCanNotBeTerminatedException
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    protected function validateRequest(Request $request): void
    {
        $this->validateParameter($request, ['contractNumber', 'toDate']);

        $contractNumber = (int)$request->get('contractNumber');
        $this->validateContract($contractNumber);

        $terminationDate = $request->get('toDate');
        $this->validateTerminationDate($terminationDate);
    }

    /**
     * @param int $contractNumber
     * @throws ContractCanNotBeTerminatedException
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
     */
    private function validateContract(int $contractNumber): void
    {
        /**
         * @note this is a stateless example.
         * $contracts should be read from the session or other cache layer, not from the database.
         */
        $contract = $this->getRepository()->getContractByNumber($contractNumber, true);

        if ($contract->isInactive()) {
            throw new ContractCanNotBeTerminatedException(ResultCodes::CONTRACT_ALREADY_INACTIVE);
        }

        if ($contract->isTerminated()) {
            throw new ContractCanNotBeTerminatedException(ResultCodes::CONTRACT_ALREADY_TERMINATED);
        }

        if ($contract->isFinished()) {
            throw new ContractCanNotBeTerminatedException(ResultCodes::CONTRACT_ALREADY_FINISHED);
        }
    }

    /**
     * @param string $date
     * @throws ContractCanNotBeTerminatedException
     */
    private function validateTerminationDate(string $date): void
    {
        $toDate = new DateTimeImmutable($date);
        $nowDate = new DateTimeImmutable();

        if ($nowDate->diff($toDate)->invert !== 0) {
            throw new ContractCanNotBeTerminatedException(ResultCodes::CONTRACT_TERMINATION_IN_THE_PAST);
        }
    }
}
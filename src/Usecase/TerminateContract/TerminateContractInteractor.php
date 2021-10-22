<?php

namespace App\Usecase\TerminateContract;

use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use App\Usecase\TerminateContract\Exceptions\ContractCanNotBeTerminated;
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

            $contractNumber = (int)$request->get('contractNumber');
            $this->validateContract($contractNumber);

            $this->getRepository()->terminateContractByNumber($contractNumber);
        } catch (Throwable $exception) {
            $code = $exception->getCode();
        }

        return new BaseResponse($code);
    }

    /**
     * @inheritDoc
     */
    protected function validateRequest(Request $request): void
    {
        $this->validateContractNumber($request);
        $this->validateDate($request);
    }

    /**
     * @param int $contractNumber
     * @throws ContractCanNotBeTerminated
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws ObjectNotFoundException (not here)
     * @throws RisksNotFoundException (not here)
     */
    private function validateContract(int $contractNumber): void
    {
        $contract = $this->getRepository()->getContractByNumber($contractNumber, true);

        if ($contract->isInactive()) {
            throw new ContractCanNotBeTerminated(ResultCodes::CONTRACT_INACTIVE);
        }

        if ($contract->isTerminated()) {
            throw new ContractCanNotBeTerminated(ResultCodes::CONTRACT_TERMINATED);
        }

        if ($contract->isFinished()) {
            throw new ContractCanNotBeTerminated(ResultCodes::CONTRACT_FINISHED);
        }
    }
}
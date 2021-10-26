<?php

namespace App\Usecase\TerminateContract;

use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\Exception\BadRequestException;
use App\Usecase\Exception\DeclineByContractException;
use App\Usecase\Exception\MissingParameterException;
use App\Usecase\ResultCodes;
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
     * @throws BadRequestException
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws DeclineByContractException
     * @throws MissingParameterException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
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
     * @param string $date
     * @throws DeclineByContractException
     */
    private function validateTerminationDate(string $date): void
    {
        $toDate = new DateTimeImmutable($date);
        $nowDate = new DateTimeImmutable();

        if ($nowDate->diff($toDate)->invert !== 0) {
            throw new DeclineByContractException(ResultCodes::CONTRACT_TERMINATION_IN_THE_PAST);
        }
    }
}
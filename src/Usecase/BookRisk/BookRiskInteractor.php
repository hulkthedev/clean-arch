<?php

namespace App\Usecase\BookRisk;

use App\Entity\Risk;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\BookRisk\Exception\RiskCanNotBeBookedException;
use App\Usecase\BookRisk\Exception\RiskTypeNotFoundException;
use App\Usecase\Exception\BadRequestException;
use App\Usecase\Exception\DeclineByContractException;
use App\Usecase\Exception\MissingParameterException;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class BookRiskInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS;
        $contract = [];

        try {
            $this->validateRequest($request);
            $this->getRepository()->bookRisk((int)$request->get('contractNumber'), (int)$request->get('objectId'), (int)$request->get('riskType'));
        } catch (Throwable $throwable) {
            $code = $throwable->getCode();
        }

        return new BaseResponse($code, [$contract]);
    }

    /**
     * @param Request $request
     * @throws BadRequestException
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws MissingParameterException
     * @throws ObjectNotFoundException
     * @throws RiskTypeNotFoundException
     * @throws RisksNotFoundException
     * @throws DeclineByContractException
     */
    protected function validateRequest(Request $request): void
    {
        $this->validateParameter($request, ['contractNumber', 'objectId', 'riskType']);

        $contractNumber = (int)$request->get('contractNumber');
        $this->validateContract($contractNumber);

        $objectId = (int)$request->get('objectId');
        $this->validateObject($objectId);

        $riskType = (int)$request->get('riskType');
        $this->validateRiskType($objectId, $riskType);
    }

    /**
     * @param int $objectId
     * @throws DeclineByContractException
     * @throws ObjectNotFoundException
     */
    private function validateObject(int $objectId): void
    {
        if (null === $object = $this->contract->getObjectById($objectId)) {
            throw new ObjectNotFoundException();
        }

        if ($object->isTerminated()) {
            throw new DeclineByContractException(ResultCodes::OBJECT_ALREADY_TERMINATED);
        }

        if ($object->isFinished()) {
            throw new DeclineByContractException(ResultCodes::OBJECT_ALREADY_FINISHED);
        }
    }

    /**
     * @param int $riskType
     * @throws RiskTypeNotFoundException
     */
    private function validateRiskType(int $riskType): void
    {
        if (!in_array($riskType, Risk::getAvailableTypes())) {
            throw new RiskTypeNotFoundException();
        }
    }
}

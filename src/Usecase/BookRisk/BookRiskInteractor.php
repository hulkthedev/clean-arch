<?php

namespace App\Usecase\BookRisk;

use App\Entity\Contract;
use App\Entity\ObjectItem;
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
use App\Usecase\Exception\MissingParameterException;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class BookRiskInteractor extends BaseInteractor
{
    /** @var Contract */
    private Contract $contract;

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
     * @throws RiskCanNotBeBookedException
     * @throws RiskTypeNotFoundException
     * @throws RisksNotFoundException
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
     * @param int $contractNumber
     * @throws ContractNotFoundException
     * @throws DatabaseUnreachableException
     * @throws ObjectNotFoundException
     * @throws RiskCanNotBeBookedException
     * @throws RisksNotFoundException
     */
    private function validateContract(int $contractNumber): void
    {
        /**
         * @note this is a stateless example.
         * $contracts should be read from the session or other cache layer, not from the database.
         */
        $this->contract = $this->getRepository()->getContractByNumber($contractNumber);

        if ($this->contract->isInactive()) {
            throw new RiskCanNotBeBookedException(ResultCodes::CONTRACT_ALREADY_INACTIVE);
        }

        if ($this->contract->isTerminated()) {
            throw new RiskCanNotBeBookedException(ResultCodes::CONTRACT_ALREADY_TERMINATED);
        }

        if ($this->contract->isFinished()) {
            throw new RiskCanNotBeBookedException(ResultCodes::CONTRACT_ALREADY_FINISHED);
        }
    }

    /**
     * @param int $objectId
     * @throws RiskCanNotBeBookedException
     * @throws ObjectNotFoundException
     */
    private function validateObject(int $objectId): void
    {
        if (null === $object = $this->contract->getObjectById($objectId)) {
            throw new ObjectNotFoundException();
        }

        if ($object->isTerminated()) {
            throw new RiskCanNotBeBookedException(ResultCodes::OBJECT_ALREADY_TERMINATED);
        }

        if ($object->isFinished()) {
            throw new RiskCanNotBeBookedException(ResultCodes::OBJECT_ALREADY_FINISHED);
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

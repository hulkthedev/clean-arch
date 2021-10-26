<?php

namespace App\Usecase\BookRisk;

use App\Entity\Risk;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\Exception\BadRequestException;
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

            $contractNumber = (int)$request->get('contractNumber');
            $objectId = (int)$request->get('objectId');
            $this->validateObject($contractNumber, $objectId);

            $riskType = (int)$request->get('riskType');
            $this->validateRiskType($riskType);

            die('TOT');

            $this->getRepository()->bookRisk($contractNumber, $objectId, $riskType);

        } catch (Throwable $throwable) {
            $code = $throwable->getCode();
        }

        return new BaseResponse($code, [$contract]);
    }

    /**
     * @param Request $request
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    protected function validateRequest(Request $request): void
    {
        $this->validateParameter($request, ['contractNumber', 'objectId', 'riskType']);
    }

    /**
     * @param int $contractNumber
     * @param int $objectId
     */
    private function validateObject(int $contractNumber, int $objectId): void
    {

    }

    private function validateRiskType(int $riskType): void
    {
        if (!in_array($riskType, Risk::getAvailableTypes())) {

        }
    }
}

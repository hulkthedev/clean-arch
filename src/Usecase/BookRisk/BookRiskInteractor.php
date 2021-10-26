<?php

namespace App\Usecase\BookRisk;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\Exceptions\BadRequestException;
use App\Usecase\Exceptions\MissingParameterException;
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


            die('TOT');

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
}

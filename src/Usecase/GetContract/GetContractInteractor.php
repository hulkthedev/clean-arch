<?php

namespace App\Usecase\GetContract;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class GetContractInteractor extends BaseInteractor
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
            $contract = $this->getRepository()->getContractByNumber((int)$request->get('contractNumber'));
        } catch (Throwable $throwable) {
            $code = $throwable->getCode();
        }

        return new BaseResponse($code, [$contract]);
    }

    /**
     * @inheritDoc
     */
    protected function validateRequest(Request $request): void
    {
        $this->validateContractNumber($request);
    }
}

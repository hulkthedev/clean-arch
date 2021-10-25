<?php

namespace App\Tests\Usecase\GetContract;

use App\Tests\Entity\ContractStub;
use App\Usecase\BaseResponse;
use App\Usecase\GetContract\GetContractInteractor;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;

class GetContractInteractorStub extends GetContractInteractor
{
    private bool $validResponse;

    /**
     * @param bool $validResponse
     */
    public function __construct(bool $validResponse = true)
    {
        $this->validResponse = $validResponse;
    }

    /**
     * @inheritDoc
     */
    public function execute(Request $request): BaseResponse
    {
        return $this->validResponse
            ? new BaseResponse(ResultCodes::SUCCESS, [new ContractStub()])
            : new BaseResponse(ResultCodes::CONTRACT_NOT_FOUND);
    }
}

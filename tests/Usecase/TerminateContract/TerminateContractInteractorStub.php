<?php

namespace App\Tests\Usecase\TerminateContract;

use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use App\Usecase\TerminateContract\TerminateContractInteractor;
use Symfony\Component\HttpFoundation\Request;

class TerminateContractInteractorStub extends TerminateContractInteractor
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
            ? new BaseResponse(ResultCodes::SUCCESS, [])
            : new BaseResponse(ResultCodes::CONTRACT_TERMINATION_ERROR);
    }
}

<?php


namespace App\Tests\Usecase\UpdateUser;

use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use App\Usecase\UpdateUser\UpdateUserInteractor;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserInteractorStub extends UpdateUserInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(Request $request): BaseResponse
    {
        return new BaseResponse(ResultCodes::SUCCESS_NO_CONTENT);
    }
}

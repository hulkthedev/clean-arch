<?php

namespace App\Tests\Usecase\DeleteUser;

use App\Usecase\BaseResponse;
use App\Usecase\DeleteUser\DeleteUserInteractor;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserInteractorStub extends DeleteUserInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(Request $request): BaseResponse
    {
        return new BaseResponse(ResultCodes::SUCCESS);
    }
}

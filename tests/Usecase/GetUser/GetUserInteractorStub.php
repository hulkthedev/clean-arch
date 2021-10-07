<?php


namespace App\Tests\Usecase\GetUser;

use App\Tests\Entity\UserStub;
use App\Usecase\BaseResponse;
use App\Usecase\GetUser\GetUserInteractor;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;

class GetUserInteractorStub extends GetUserInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(Request $request): BaseResponse
    {
        return new BaseResponse(ResultCodes::SUCCESS, [new UserStub()]);
    }
}

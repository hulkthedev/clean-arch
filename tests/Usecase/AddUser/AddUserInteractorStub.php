<?php

namespace App\Tests\Usecase\AddUser;

use App\Usecase\AddUser\AddUserInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;

class AddUserInteractorStub extends AddUserInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(Request $request): BaseResponse
    {
        $response = new BaseResponse(ResultCodes::SUCCESS_CREATED);
        $response->setHeaders(['Location' => "/1000"]);

        return $response;
    }
}

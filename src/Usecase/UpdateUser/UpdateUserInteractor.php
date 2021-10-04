<?php

namespace App\Usecase\UpdateUser;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class UpdateUserInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS;

        try {

        } catch (Throwable $throwable) {

        }

        return new BaseResponse($code);
    }

    /**
     * @param Request $request
     */
    private function validateRequest(Request $request)
    {

    }
}

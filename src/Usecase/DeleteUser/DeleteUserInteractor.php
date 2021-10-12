<?php

namespace App\Usecase\DeleteUser;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class DeleteUserInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS_NO_CONTENT;

        try {
            $this->validateRequest($request);
            $this->getRepository()->deleteUserById((int)$request->get('userId'));
        } catch (BadRequestException $exception) {
            $code = ResultCodes::INVALID_SYNTAX;
        } catch(DatabaseException $exception) {
            $code = ResultCodes::USER_CAN_NOT_BE_DELETED;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        return new BaseResponse($code);
    }

    /**
     * @param Request $request
     * @throws BadRequestException
     */
    private function validateRequest(Request $request): void
    {
        if (null === $request->get('userId')) {
            throw new BadRequestException('No userId transmitted!');
        }

        if ((int)$request->get('userId') === 0) {
            throw new BadRequestException('No valid userId transmitted!');
        }
    }
}

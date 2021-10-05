<?php

namespace App\Usecase\DeleteUser;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
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
        } catch (InvalidArgumentException $exception) {
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
     */
    private function validateRequest(Request $request)
    {
        if (null === $request->get('userId')) {
            throw new InvalidArgumentException('No userId transmitted!');
        }

        if (!is_integer((int)$request->get('userId'))) {
            throw new InvalidArgumentException('No valid userId transmitted!');
        }
    }
}

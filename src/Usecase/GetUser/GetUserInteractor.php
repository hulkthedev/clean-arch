<?php

namespace App\Usecase\GetUser;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class GetUserInteractor extends BaseInteractor
{
    /**
     * @param GetUserRequest $request
     * @return BaseResponse
     */
    public function execute(GetUserRequest $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS;
        $user = [];

        try {
            $this->validateRequest($request);
            $user = $this->getRepository()->getUserById($request->userId);
        } catch (BadRequestException $exception) {
            $code = ResultCodes::INVALID_SYNTAX;
        } catch (DatabaseException $exception) {
            $code = ResultCodes::USER_NOT_FOUND;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        return new BaseResponse($code, $user);
    }

    /**
     * @param GetUserRequest $request
     * @throws BadRequestException
     */
    private function validateRequest(GetUserRequest $request): void
    {
        if (null === $request->userId) {
            throw new BadRequestException('No userId transmitted!');
        }

        if (0 === $request->userId) {
            throw new BadRequestException('No valid userId transmitted!');
        }
    }
}

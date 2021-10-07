<?php

namespace App\Usecase\GetUser;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

class GetUserInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS;
        $user = [];

        try {
            $this->validateRequest($request);
            $user = $this->getRepository()->getUserById((int)$request->get('userId'));
        } catch (InvalidArgumentException $exception) {
            $code = ResultCodes::INVALID_SYNTAX;
        } catch (DatabaseException $exception) {
            $code = ResultCodes::USER_NOT_FOUND;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        return new BaseResponse($code, $user);
    }

    /**
     * @param Request $request
     * @throws UnsupportedMediaTypeHttpException
     * @throws InvalidArgumentException
     */
    private function validateRequest(Request $request): void
    {
        if (null === $request->get('userId')) {
            throw new InvalidArgumentException('No userId transmitted!');
        }

        if ((int)$request->get('userId') === 0) {
            throw new InvalidArgumentException('No valid userId transmitted!');
        }
    }
}

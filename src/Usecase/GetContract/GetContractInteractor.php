<?php

namespace App\Usecase\GetContract;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

class GetContractInteractor extends BaseInteractor
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
            $contract = $this->getRepository()->getContractByNumber((int)$request->get('contractNumber'));

            var_dump($contract);die();

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
     * @param Request $request
     * @throws UnsupportedMediaTypeHttpException
     * @throws BadRequestException
     */
    private function validateRequest(Request $request): void
    {
        if (null === $request->get('contractId')) {
            throw new BadRequestException('No contractId transmitted!');
        }

        if ((int)$request->get('contractId') === 0) {
            throw new BadRequestException('No valid contractId transmitted!');
        }
    }
}

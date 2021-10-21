<?php

namespace App\Usecase\GetContract;

use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
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
        $contract = [];

        try {
            $this->validateRequest($request);
            $contract = $this->getRepository()->getContractByNumber((int)$request->get('contractNumber'));
        } catch (BadRequestException $exception) {
            $code = ResultCodes::INVALID_SYNTAX;
        } catch (DatabaseUnreachableException $exception) {
            $code = ResultCodes::DATABASE_UNREACHABLE;
        } catch (ContractNotFoundException $exception) {
            $code = ResultCodes::CONTRACT_NOT_FOUND;
        } catch (ObjectNotFoundException $exception) {
            $code = ResultCodes::OBJECT_NOT_FOUND;
        } catch (RisksNotFoundException $exception) {
            $code = ResultCodes::RISKS_NOT_FOUND;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        return new BaseResponse($code, [$contract]);
    }

    /**
     * @inheritDoc
     */
    protected function validateRequest(Request $request): void
    {
        $this->validateContractNumber($request);
    }
}

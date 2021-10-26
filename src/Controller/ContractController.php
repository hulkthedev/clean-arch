<?php

namespace App\Controller;

use App\Usecase\GetContract\GetContractInteractor;
use App\Usecase\TerminateContract\TerminateContractInteractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractController extends BaseController
{
    /**
     * @param Request $request
     * @param GetContractInteractor $interactor
     * @return Response
     */
    public function get(Request $request, GetContractInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $request
     * @param TerminateContractInteractor $interactor
     * @return Response
     */
    public function terminate(Request $request, TerminateContractInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }
}

<?php

namespace App\Controller;

use App\Usecase\GetContract\GetContractInteractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractController
{
    /**
     * @param Request $request
     * @param GetContractInteractor $interactor
     * @return Response
     */
    public function getContract(Request $request, GetContractInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $request
     * @param GetContractInteractor $interactor
     * @return Response
     */
    public function getObject(Request $request, GetContractInteractor $interactor): Response
    {

    }

    /**
     * @param mixed $content
     * @param int $status
     * @param array $header
     * @return Response
     */
    protected function createResponse($content, int $status = Response::HTTP_OK, array $header = []): Response
    {
        return new Response(json_encode($content), $status, array_merge(['Content-Type' => 'application/json'], $header));
    }
}

<?php

namespace App\Controller;

use App\Usecase\BookRisk\BookRiskInteractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ObjectController extends BaseController
{
    /**
     * @param Request $request
     * @param BookRiskInteractor $interactor
     * @return Response
     */
    public function bookRisk(Request $request, BookRiskInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }
}

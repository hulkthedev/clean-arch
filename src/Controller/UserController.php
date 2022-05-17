<?php

namespace App\Controller;

use App\Usecase\AddUser\AddUserInteractor;
use App\Usecase\DeleteUser\DeleteUserInteractor;
use App\Usecase\GetUser\GetUserInteractor;
use App\Usecase\GetUser\GetUserRequest;
use App\Usecase\UpdateUser\UpdateUserInteractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    /**
     * @param Request $httpRequest
     * @param GetUserInteractor $interactor
     * @return Response
     */
    public function getUser(Request $httpRequest, GetUserInteractor $interactor): Response
    {
        $userId = $httpRequest->get('userId');
        $request = new GetUserRequest($userId);

        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $httpRequest
     * @param AddUserInteractor $interactor
     * @return Response
     */
    public function addUser(Request $httpRequest, AddUserInteractor $interactor): Response
    {
        $response = $interactor->execute($httpRequest);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus(), $response->getHeaders());
    }

    /**
     * @param Request $httpRequest
     * @param UpdateUserInteractor $interactor
     * @return Response
     */
    public function updateUser(Request $httpRequest, UpdateUserInteractor $interactor): Response
    {
        $response = $interactor->execute($httpRequest);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $httpRequest
     * @param DeleteUserInteractor $interactor
     * @return Response
     */
    public function deleteUser(Request $httpRequest, DeleteUserInteractor $interactor): Response
    {
        $response = $interactor->execute($httpRequest);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
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

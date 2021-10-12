<?php

namespace App\Controller;

use App\Usecase\AddUser\AddUserInteractor;
use App\Usecase\DeleteUser\DeleteUserInteractor;
use App\Usecase\GetUser\GetUserInteractor;
use App\Usecase\UpdateUser\UpdateUserInteractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController
{
//    private SerializerInterface $serializer;
//
//    public function __construct()
//    {
//        $serializer = new Serializer([new ObjectNormalizer(), new DateTimeNormalizer()], [new JsonEncoder()]);
//        $this->serializer =  $serializer;
//    }

    /**
     * @param Request $request
     * @param GetUserInteractor $interactor
     * @return Response
     */
    public function getUser(Request $request, GetUserInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $request
     * @param AddUserInteractor $interactor
     * @return Response
     */
    public function addUser(Request $request, AddUserInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus(), $response->getHeaders());
    }

    /**
     * @param Request $request
     * @param UpdateUserInteractor $interactor
     * @return Response
     */
    public function updateUser(Request $request, UpdateUserInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $request
     * @param DeleteUserInteractor $interactor
     * @return Response
     */
    public function deleteUser(Request $request, DeleteUserInteractor $interactor): Response
    {
        $response = $interactor->execute($request);
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

<?php


namespace App\Tests\Controller;


use App\Controller\UserController;
use App\Tests\Usecase\AddUser\AddUserInteractorStub;
use App\Tests\Usecase\DeleteUser\DeleteUserInteractorStub;
use App\Tests\Usecase\GetUser\GetUserInteractorStub;
use App\Tests\Usecase\UpdateUser\UpdateUserInteractorStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends TestCase
{
    private UserController $controller;
    private Request $request;

    public function setUp(): void
    {
        $this->controller = new UserController();
        $this->request = new Request();
    }

    public function test_GetUser(): void
    {
        $interactor = new GetUserInteractorStub();
        $response = $this->controller->getUser($this->request, $interactor);

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":1,"entities":[{"id":1000,"firstname":"Max","lastname":"Mustermann","age":30,"gender":"m","street":"Musterstra\u00dfe","houseNumber":"3a","postcode":"12345","city":"Musterdorf","country":"Musterland"}]}',
            $response->getContent()
        );
    }

    public function test_AddUser(): void
    {
        $interactor = new AddUserInteractorStub();
        $response = $this->controller->addUser($this->request, $interactor);

        TestCase::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":2,"entities":[]}',
            $response->getContent()
        );
    }

    public function test_UpdateUser(): void
    {
        $interactor = new UpdateUserInteractorStub();
        $response = $this->controller->updateUser($this->request, $interactor);

        TestCase::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":3,"entities":[]}',
            $response->getContent()
        );
    }

    public function test_DeleteUser(): void
    {
        $interactor = new DeleteUserInteractorStub();
        $response = $this->controller->deleteUser($this->request, $interactor);

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":1,"entities":[]}',
            $response->getContent()
        );
    }
}

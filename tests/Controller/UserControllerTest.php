<?php
//
//
//namespace App\Tests\Controller;
//
//
//use App\Controller\ContractController;
//use App\Usecase\GetContract\GetContractInteractor;
//use PHPUnit\Framework\TestCase;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//
//class UserControllerTest extends TestCase
//{
//    private ContractController $controller;
//    private Request $request;
//
//    public function setUp(): void
//    {
//        $this->controller = new ContractController();
//        $this->request = new Request();
//    }
//
//    public function test_GetUser(): void
//    {
//        $interactor = new GetContractInteractor();
//        $response = $this->controller->get($this->request, $interactor);
//
//        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
//        TestCase::assertEquals(
//            '{"code":1,"entities":[{"id":1000,"firstname":"Max","lastname":"Mustermann","age":30,"gender":"m","street":"Musterstra\u00dfe","houseNumber":"3a","postcode":"12345","city":"Musterdorf","country":"Musterland"}]}',
//            $response->getContent()
//        );
//    }
//
//
//}

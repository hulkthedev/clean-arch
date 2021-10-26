<?php


namespace App\Tests\Controller;


use App\Controller\ContractController;
use App\Tests\Usecase\GetContract\GetContractInteractorStub;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractControllerTest extends TestCase
{
    private ContractController $controller;
    private Request $request;

    public function setUp(): void
    {
        $this->controller = new ContractController();
        $this->request = new Request();
    }

    public function test_Get_ExpectValidJsonResult(): void
    {
        $interactor = new GetContractInteractorStub();
        $response = $this->controller->get($this->request, $interactor);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertCount(1, json_decode($response->getContent(), true)['contracts']);
    }

    public function test_Get_ExpectInvalidJsonResult(): void
    {
        $interactor = new GetContractInteractorStub(false);
        $response = $this->controller->get($this->request, $interactor);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals('{"code":-20,"contracts":[]}', $response->getContent());
    }
}

<?php


namespace App\Tests\Controller;


use App\Controller\ContractController;
use App\Tests\Usecase\GetContract\GetContractInteractorStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractControllerTest extends TestCase
{
    private ContractController $controller;
    private Request $request;

    public function setUp(): void
    {
        $this->markTestSkipped('Buggy');

        $this->controller = new ContractController();
        $this->request = new Request();
    }

    public function test_Get(): void
    {
        $interactor = new GetContractInteractorStub();
        $response = $this->controller->get($this->request, $interactor);

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $expectedJson = json_decode('{"code":1,"contracts":[{"id":1,"number":1000,"customerId":1,"requestDate":{"date":"2021-01-13·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"startDate":{"date":"2021-02-01·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"endDate":null,"terminationDate":null,"dunningLevel":0,"customer":{"firstname":"Bill","lastname":"Gates","age":72,"gender":"m","street":"Windows·Ave.","houseNumber":"3422","postcode":"12F000","city":"Los·Angeles","country":"USA"},"paymentAccount":{"name":"SEPA","holder":"Bill·Gates","iban":"DE02500105170137075030","bic":"INGDDEFF","interval":30},"objects":[{"id":1,"serialNumber":"24235435436547456","price":1000,"currency":"USD","description":"Apple·iPhone·11","buyingDate":{"date":"2021-01-01·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"startDate":{"date":"2021-02-01·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_SMARTPHONE"}]}]}]}', true);
        $json = json_decode($response->getContent(), true);

        TestCase::assertEquals($expectedJson, $json);
    }


}

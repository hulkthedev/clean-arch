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

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertArrays(
            json_decode('{"code":1,"contracts":[{"id":1,"number":1000,"customerId":1,"requestDate":{"date":"2021-01-13·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"startDate":{"date":"2021-02-01·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"endDate":null,"terminationDate":null,"dunningLevel":0,"customer":{"firstname":"Bill","lastname":"Gates","age":72,"gender":"m","street":"Windows·Ave.","houseNumber":"3422","postcode":"12F000","city":"Los·Angeles","country":"USA"},"paymentAccount":{"name":"SEPA","holder":"Bill·Gates","iban":"DE02500105170137075030","bic":"INGDDEFF","interval":30},"objects":[{"id":1,"serialNumber":"24235435436547456","price":1000,"currency":"USD","description":"Apple·iPhone·11","buyingDate":{"date":"2021-01-01·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"startDate":{"date":"2021-02-01·00:00:00.000000","timezone_type":3,"timezone":"UTC"},"endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_SMARTPHONE"}]}]}]}', true),
            json_decode($response->getContent(), true)
        );
    }

    public function test_Get_ExpectInvalidJsonResult(): void
    {
        $interactor = new GetContractInteractorStub(false);
        $response = $this->controller->get($this->request, $interactor);

        TestCase::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        TestCase::assertEquals('{"code":-20,"contracts":[]}', $response->getContent());
    }

    /**
     * @param array $expected
     * @param array $got
     */
    private function assertArrays(array $expected, array $got): void
    {
        self::assertEquals($expected['code'], $got['code']);

        $expectedContract = $expected['contracts'][0];
        $gotContract = $got['contracts'][0];

        foreach ($expectedContract as $key => $value) {
            if ($this->continueIfDateTime($key)) {
                self::assertSame($value, $gotContract[$key]);
            }
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    private function continueIfDateTime(string $key): bool
    {
        return !in_array($key, [
            'requestDate',
            'startDate',
            'endDate',
            'terminationDate',
            'buyingDate'
        ]);
    }
}

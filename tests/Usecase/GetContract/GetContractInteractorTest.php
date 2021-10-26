<?php

namespace App\Tests\Usecase\GetContract;

use App\Entity\Contract;
use App\Entity\Customer;
use App\Entity\ObjectItem;
use App\Entity\PaymentAccount;
use App\Tests\Repository\MariaDbRepositoryStub;
use App\Tests\TestCaseHelper;
use App\Usecase\GetContract\GetContractInteractor;
use App\Usecase\ResultCodes;

class GetContractInteractorTest extends TestCaseHelper
{
    public function test_ExpectExceptionWhenNoDataWasPosted(): void
    {
        $request = $this->getHttpRequest([]);
        $response = (new GetContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenInvalidDataWasPosted(): void
    {
        $request = $this->getHttpRequest(['contractId' => 'xxx']);
        $response = (new GetContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenDatabaseThrowsError(): void
    {
        $request = $this->getHttpRequest();
        $response = (new GetContractInteractor(new MariaDbRepositoryStub(['getContractByNumber' => true])))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::CONTRACT_NOT_FOUND, $response['code']);
    }

    public function test_ExpectNoError(): void
    {
        $request = $this->getHttpRequest();
        $response = (new GetContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::SUCCESS, $response['code']);

        self::assertCount(1, $response['contracts']);
        self::assertInstanceOf(Contract::class, $response['contracts'][0]);

        self::assertCount(1, $response['contracts'][0]->getObjects());
        self::assertInstanceOf(ObjectItem::class, $response['contracts'][0]->getObjects()[0]);

        self::assertInstanceOf(PaymentAccount::class, $response['contracts'][0]->getPaymentAccount());
        self::assertInstanceOf(Customer::class, $response['contracts'][0]->getCustomer());
    }
}

<?php

namespace App\Tests\Usecase\TerminateContract;

use App\Tests\Repository\MariaDbRepositoryStub;
use App\Tests\TestCaseHelper;
use App\Usecase\ResultCodes;
use App\Usecase\TerminateContract\TerminateContractInteractor;

class TerminateContractInteractorTest extends TestCaseHelper
{
    public function test_ExpectExceptionWhenNoDataWasPosted(): void
    {
        $request = $this->getHttpRequest([]);
        $response = (new TerminateContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenInvalidDataWasPosted(): void
    {
        $request = $this->getHttpRequest(['contractId' => 'xxx']);
        $response = (new TerminateContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenNoTerminationDateWasPosted(): void
    {
        $request = $this->getHttpRequest(['contractNumber' => 1000]);
        $response = (new TerminateContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenDatabaseThrowsError(): void
    {
        $request = $this->getHttpRequest(['contractNumber' => 1000, 'toDate' => '2021-12-01']);
        $response = (new TerminateContractInteractor(new MariaDbRepositoryStub(['terminateContractByNumber' => true])))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::CONTRACT_TERMINATION_ERROR, $response['code']);
    }

    public function test_ExpectNoError(): void
    {
        $request = $this->getHttpRequest(['contractNumber' => 1000, 'toDate' => '2021-12-01']);
        $response = (new TerminateContractInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::SUCCESS, $response['code']);
        self::assertCount(0, $response['contracts']);
    }
}

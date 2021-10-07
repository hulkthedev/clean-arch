<?php

namespace App\Tests\Usecase\GetUser;

use App\Tests\Repository\MariaDbRepositoryStub;
use App\Usecase\GetUser\GetUserInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class GetUserInteractorTest extends TestCase
{
    public function test_ExpectExceptionWhenNoDataWasPosted(): void
    {
        $request = $this->getHttpRequest([]);

        $response = (new GetUserInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenInvalidDataWasPosted(): void
    {
        $request = $this->getHttpRequest(['userId' => 'xxx']);

        $response = (new GetUserInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenDatabaseThrowsError(): void
    {
        $request = $this->getHttpRequest();
        $response = (new GetUserInteractor(new MariaDbRepositoryStub(true)))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::USER_NOT_FOUND, $response['code']);
    }

    public function test_ExpectNoError(): void
    {
        $request = $this->getHttpRequest();
        $response = (new GetUserInteractor(new MariaDbRepositoryStub()))->execute($request);

        self::assertEquals(ResultCodes::SUCCESS, $response->presentResponse()['code']);
    }

    /**
     * @param array $query
     * @return Request
     */
    private function getHttpRequest(array $query = ['userId' => 1000]): Request
    {
        return new Request($query);
    }
}

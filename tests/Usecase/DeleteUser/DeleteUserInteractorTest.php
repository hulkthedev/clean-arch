<?php

namespace App\Tests\Usecase\DeleteUser;

use App\Tests\Entity\UserStub;
use App\Tests\Repository\MariaDbRepositoryStub;
use App\Usecase\DeleteUser\DeleteUserInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserInteractorTest extends TestCase
{
    public function test_ExpectExceptionWhenNoDataWasPosted(): void
    {
        $request = $this->getHttpRequest([]);

        $response = (new DeleteUserInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenInvalidDataWasPosted(): void
    {
        $request = $this->getHttpRequest(['userId' => 'xxx']);

        $response = (new DeleteUserInteractor(new MariaDbRepositoryStub()))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenDatabaseThrowsError(): void
    {
        $request = $this->getHttpRequest();
        $response = (new DeleteUserInteractor(new MariaDbRepositoryStub(true)))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::USER_CAN_NOT_BE_DELETED, $response['code']);
    }

    public function test_ExpectNoError(): void
    {
        $request = $this->getHttpRequest();
        $response = (new DeleteUserInteractor(new MariaDbRepositoryStub()))->execute($request);

        self::assertEquals(ResultCodes::SUCCESS_NO_CONTENT, $response->presentResponse()['code']);
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

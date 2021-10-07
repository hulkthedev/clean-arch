<?php

namespace App\Tests\Usecase\AddUser;

use App\Entity\User;
use App\Tests\Entity\UserStub;
use App\Tests\Repository\MariaDbRepositoryStub;
use App\Usecase\AddUser\AddUserInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AddUserInteractorTest extends TestCase
{
    public function test_ExpectExceptionWhenWrongContentTypeIsGiven(): void
    {
        $interactor = new AddUserInteractor(new MariaDbRepositoryStub());

        $request = $this->getHttpRequest(new UserStub(), 'text/html');
        $response = $interactor->execute($request)->presentResponse();

        self::assertEquals(ResultCodes::INVALID_MEDIA_TYPE, $response['code']);
    }

    public function test_ExpectExceptionWhenNoDataWasPosted(): void
    {
        $interactor = new AddUserInteractor(new MariaDbRepositoryStub());

        $dto = new UserStub();
        unset($dto->firstname);

        $request = $this->getHttpRequest($dto);
        $response = $interactor->execute($request)->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenDatabaseThrowsError(): void
    {
        $interactor = new AddUserInteractor(new MariaDbRepositoryStub(true));

        $request = $this->getHttpRequest(new UserStub());
        $response = $interactor->execute($request)->presentResponse();

        self::assertEquals(ResultCodes::USER_CAN_NOT_BE_SAVED, $response['code']);
    }

    public function test_ExpectNoError(): void
    {
        $interactor = new AddUserInteractor(new MariaDbRepositoryStub());

        $request = $this->getHttpRequest(new UserStub());
        $response = $interactor->execute($request);

        self::assertEquals(ResultCodes::SUCCESS_CREATED, $response->presentResponse()['code']);
        self::assertEquals(['Location' => 'http://:/1000'], $response->getHeaders());
    }

    /**
     * @param User $dto
     * @param string $contentType
     * @return Request
     */
    private function getHttpRequest(User $dto, string $contentType = 'application/json'): Request
    {
        $request = new Request([], [], [], [], [], [], json_encode($dto));
        $request->headers->set('Content-Type', $contentType);

        return $request;
    }
}

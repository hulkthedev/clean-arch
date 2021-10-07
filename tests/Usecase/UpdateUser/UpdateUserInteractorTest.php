<?php

namespace App\Tests\Usecase\UpdateUser;

use App\Entity\User;
use App\Tests\Entity\UserStub;
use App\Tests\Repository\MariaDbRepositoryStub;
use App\Usecase\UpdateUser\UpdateUserInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserInteractorTest extends TestCase
{
    public function test_ExpectExceptionWhenWrongContentTypeIsGiven(): void
    {
        $request = $this->getHttpRequest(new UserStub(), [], 'text/html');
        $response = (new UpdateUserInteractor(new MariaDbRepositoryStub()))->execute($request)->presentResponse();

        self::assertEquals(ResultCodes::INVALID_MEDIA_TYPE, $response['code']);
    }

    public function test_ExpectExceptionWhenNoQueryDataWasPosted(): void
    {
        $request = $this->getHttpRequest(new UserStub(), []);
        $response = (new UpdateUserInteractor(new MariaDbRepositoryStub()))->execute($request)->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenInvalidQueryDataWasPosted(): void
    {
        $request = $this->getHttpRequest(new UserStub(), ['userId' => 'xxx']);
        $response = (new UpdateUserInteractor(new MariaDbRepositoryStub()))->execute($request)->presentResponse();

        self::assertEquals(ResultCodes::INVALID_SYNTAX, $response['code']);
    }

    public function test_ExpectExceptionWhenDatabaseThrowsError(): void
    {
        $request = $this->getHttpRequest(new UserStub());
        $response = (new UpdateUserInteractor(new MariaDbRepositoryStub(true)))
            ->execute($request)
            ->presentResponse();

        self::assertEquals(ResultCodes::USER_CAN_NOT_BE_UPDATED, $response['code']);
    }

    public function test_ExpectNoError(): void
    {
        $request = $this->getHttpRequest(new UserStub());
        $response = (new UpdateUserInteractor(new MariaDbRepositoryStub()))->execute($request);

        self::assertEquals(ResultCodes::SUCCESS_NO_CONTENT, $response->presentResponse()['code']);
    }

    /**
     * @param User $dto
     * @param array $query
     * @param string $contentType
     * @return Request
     */
    private function getHttpRequest(User $dto, array $query = ['userId' => 1000], string $contentType = 'application/json'): Request
    {
        $request = new Request($query, [], [], [], [], [], json_encode($dto));
        $request->headers->set('Content-Type', $contentType);

        return $request;
    }
}

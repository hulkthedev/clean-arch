<?php

namespace App\Tests\Usecase;

use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class BaseResponseTest extends TestCase
{
    public function test_SetGetHeader_ExpectRightHandling(): void
    {
        $response = new BaseResponse(ResultCodes::SUCCESS);
        self::assertEquals([], $response->getHeaders());

        $response->setHeaders(['foo' => ['bar']]);
        self::assertEquals(['foo' => ['bar']], $response->getHeaders());
    }

    /**
     * @return array
     */
    public function dataProviderResultCodes(): array
    {
        return [
            [ResultCodes::SUCCESS, Response::HTTP_OK],
            [ResultCodes::INVALID_MEDIA_TYPE, Response::HTTP_UNSUPPORTED_MEDIA_TYPE],

            [ResultCodes::INVALID_JSON_CONTENT, Response::HTTP_BAD_REQUEST],
            [ResultCodes::INVALID_SYNTAX, Response::HTTP_BAD_REQUEST],
            [ResultCodes::MISSING_PARAMETER, Response::HTTP_BAD_REQUEST],

            [ResultCodes::RISKS_NOT_FOUND, Response::HTTP_BAD_REQUEST],
            [ResultCodes::OBJECT_NOT_FOUND, Response::HTTP_BAD_REQUEST],
            [ResultCodes::CONTRACT_NOT_FOUND, Response::HTTP_BAD_REQUEST],

            [ResultCodes::CONTRACT_ALREADY_FINISHED, Response::HTTP_INTERNAL_SERVER_ERROR],
            [ResultCodes::CONTRACT_ALREADY_INACTIVE, Response::HTTP_INTERNAL_SERVER_ERROR],
            [ResultCodes::CONTRACT_ALREADY_TERMINATED, Response::HTTP_INTERNAL_SERVER_ERROR],
            [ResultCodes::CONTRACT_TERMINATION_IN_THE_PAST, Response::HTTP_INTERNAL_SERVER_ERROR],
            [ResultCodes::CONTRACT_TERMINATION_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR],

            [ResultCodes::DATABASE_UNREACHABLE, Response::HTTP_INTERNAL_SERVER_ERROR],
            [ResultCodes::UNKNOWN_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR],
            [112233, Response::HTTP_INTERNAL_SERVER_ERROR]
        ];
    }

    /**
     * @dataProvider dataProviderResultCodes
     * @param int $resultCode
     * @param int $httpResponseCode
     */
    public function test_GetHttpStatus_ExpectRightAssignment(int $resultCode, int $httpResponseCode): void
    {
        $response = new BaseResponse($resultCode);
        self::assertEquals($httpResponseCode, $response->getHttpStatus());

        $presentResponse = $response->presentResponse();
        self::assertEquals($resultCode, $presentResponse['code']);
        self::assertEquals([], $presentResponse['contracts']);
    }
}

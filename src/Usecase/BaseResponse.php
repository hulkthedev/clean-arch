<?php

namespace App\Usecase;

use Symfony\Component\HttpFoundation\Response;

class BaseResponse
{
    private int $code = ResultCodes::SUCCESS;
    private array $entities;
    private array $headers = [];

    /**
     * @param int $code
     * @param array $entities
     */
    public function __construct(int $code, array $entities = [])
    {
        $this->code = $code;
        $this->entities = $entities;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        switch ($this->code) {
            case ResultCodes::SUCCESS:
            case ResultCodes::USER_NOT_FOUND:
            case ResultCodes::DATABASE_IS_EMPTY:
                return Response::HTTP_OK;
            case ResultCodes::SUCCESS_CREATED;
                return Response::HTTP_CREATED;
            case ResultCodes::SUCCESS_NO_CONTENT:
                return Response::HTTP_NO_CONTENT;
            case ResultCodes::INVALID_JSON_CONTENT:
            case ResultCodes::INVALID_SYNTAX:
            case ResultCodes::USER_CAN_NOT_BE_UPDATED:
            case ResultCodes::USER_CAN_NOT_BE_DELETED:
            case ResultCodes::USER_CAN_NOT_BE_SAVED:
                return Response::HTTP_BAD_REQUEST;
            case ResultCodes::INVALID_MEDIA_TYPE:
                return Response::HTTP_UNSUPPORTED_MEDIA_TYPE;
            case ResultCodes::PDO_EXCEPTION_NO_LOGIN_DATA:
            case ResultCodes::PDO_EXCEPTION:
            case ResultCodes::UNKNOWN_ERROR:
            default:
                return Response::HTTP_INTERNAL_SERVER_ERROR;
        }
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function presentResponse(): array
    {
        return [
            'code' => $this->code,
            'entities' => $this->entities
        ];
    }
}

<?php

namespace App\Usecase;

use JetBrains\PhpStorm\ArrayShape;
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
        return match ($this->code) {
            ResultCodes::SUCCESS, ResultCodes::USER_NOT_FOUND, ResultCodes::DATABASE_IS_EMPTY => Response::HTTP_OK,
            ResultCodes::SUCCESS_CREATED => Response::HTTP_CREATED,
            ResultCodes::SUCCESS_NO_CONTENT => Response::HTTP_NO_CONTENT,
            ResultCodes::INVALID_JSON_CONTENT, ResultCodes::INVALID_SYNTAX, ResultCodes::USER_CAN_NOT_BE_UPDATED, ResultCodes::USER_CAN_NOT_BE_DELETED, ResultCodes::USER_CAN_NOT_BE_SAVED => Response::HTTP_BAD_REQUEST,
            ResultCodes::INVALID_MEDIA_TYPE => Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
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
    #[ArrayShape(['code' => "int", 'entities' => "array"])]
    public function presentResponse(): array
    {
        return [
            'code' => $this->code,
            'entities' => $this->entities
        ];
    }
}

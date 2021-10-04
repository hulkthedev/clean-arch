<?php

namespace App\Usecase;

use Symfony\Component\HttpFoundation\Response;

class BaseResponse
{
    private int $code = ResultCodes::SUCCESS;
    private int $httpStatus = Response::HTTP_OK;
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
        return $this->httpStatus;
    }

    /**
     * @param int $httpStatus
     */
    public function setHttpStatus(int $httpStatus): void
    {
        $this->httpStatus = $httpStatus;
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

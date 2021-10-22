<?php


namespace App\Usecase\Exceptions;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class BadRequestException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::INVALID_SYNTAX);
    }
}

<?php


namespace App\Usecase\Exceptions;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class MissingParameterException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::MISSING_PARAMETER);
    }
}

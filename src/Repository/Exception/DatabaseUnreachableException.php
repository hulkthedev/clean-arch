<?php

namespace App\Repository\Exception;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class DatabaseUnreachableException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::PDO_EXCEPTION_NO_LOGIN_DATA);
    }
}

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
        parent::__construct('', ResultCodes::DATABASE_UNREACHABLE);
    }
}

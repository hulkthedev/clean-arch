<?php

namespace App\Repository\Exception;

use Exception;

/**
 * @codeCoverageIgnore
 */
class DatabaseException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct(int $code)
    {
        parent::__construct('', $code);
    }
}

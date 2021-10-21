<?php

namespace App\Repository\Exception;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class RisksNotFoundException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::RISKS_NOT_FOUND);
    }
}

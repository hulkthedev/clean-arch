<?php

namespace App\Repository\Exception;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class ContractNotFoundException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::CONTRACT_NOT_FOUND);
    }
}

<?php


namespace App\Usecase\BookRisk\Exception;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class RiskTypeNotFoundException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::RISK_TYPE_NOT_FOUND);
    }
}

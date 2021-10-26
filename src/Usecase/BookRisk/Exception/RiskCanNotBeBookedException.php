<?php


namespace App\Usecase\BookRisk\Exception;

use Exception;

/**
 * @codeCoverageIgnore
 */
class RiskCanNotBeBookedException extends Exception
{
    /**
     * @param int $resultCode
     */
    public function __construct(int $resultCode)
    {
        parent::__construct('', $resultCode);
    }
}

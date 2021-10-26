<?php


namespace App\Usecase\Exception;

use Exception;

/**
 * @codeCoverageIgnore
 */
class DeclineByContractException extends Exception
{
    /**
     * @param int $resultCode
     */
    public function __construct(int $resultCode)
    {
        parent::__construct('', $resultCode);
    }
}

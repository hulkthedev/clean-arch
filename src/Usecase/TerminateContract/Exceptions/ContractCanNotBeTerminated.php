<?php


namespace App\Usecase\TerminateContract\Exceptions;

use Exception;

/**
 * @codeCoverageIgnore
 */
class ContractCanNotBeTerminated extends Exception
{
    /**
     * @param int $resultCode
     */
    public function __construct(int $resultCode)
    {
        parent::__construct('', $resultCode);
    }
}

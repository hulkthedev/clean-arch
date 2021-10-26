<?php


namespace App\Usecase\TerminateContract\Exception;

use Exception;

/**
 * @codeCoverageIgnore
 */
class ContractCanNotBeTerminatedException extends Exception
{
    /**
     * @param int $resultCode
     */
    public function __construct(int $resultCode)
    {
        parent::__construct('', $resultCode);
    }
}

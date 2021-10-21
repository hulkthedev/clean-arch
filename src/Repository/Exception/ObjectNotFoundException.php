<?php

namespace App\Repository\Exception;

use App\Usecase\ResultCodes;
use Exception;

/**
 * @codeCoverageIgnore
 */
class ObjectNotFoundException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('', ResultCodes::OBJECT_NOT_FOUND);
    }
}

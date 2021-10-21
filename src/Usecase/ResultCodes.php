<?php

namespace App\Usecase;

class ResultCodes
{
    public const UNKNOWN_ERROR = -99;

    /** exceptions */
    public const USER_CAN_NOT_BE_UPDATED = -16;
    public const RISKS_NOT_FOUND = -15;
    public const OBJECT_NOT_FOUND = -14;
    public const CONTRACT_NOT_FOUND = -13;
    public const DATABASE_IS_EMPTY = -12;

    /** database exceptions */
    public const PDO_EXCEPTION_NO_LOGIN_DATA = -11;
    public const PDO_EXCEPTION = -10;

    /** validation */
    public const INVALID_JSON_CONTENT = -3;
    public const INVALID_MEDIA_TYPE = -2;
    public const INVALID_SYNTAX = -1;

    /** success */
    public const SUCCESS_NO_CONTENT = 3;
    public const SUCCESS_CREATED = 2;
    public const SUCCESS = 1;
}

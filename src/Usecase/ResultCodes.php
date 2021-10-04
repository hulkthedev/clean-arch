<?php

namespace App\Usecase;

class ResultCodes
{
    /* exceptions */
    public const USER_CAN_NOT_BE_UPDATED = -16;
    public const USER_CAN_NOT_BE_DELETED = -15;
    public const USER_CAN_NOT_BE_SAVED = -14;
    public const USER_NOT_FOUND = -13;
    public const DATABASE_IS_EMPTY = -12;

    public const PDO_EXCEPTION_NO_LOGIN_DATA = -11;
    public const PDO_EXCEPTION = -10;

    /* validation */
    public const INVALID_JSON_CONTENT = -3;
    public const INVALID_MEDIA_TYPE = -2;
    public const INVALID_SYNTAX = -1;

    public const UNKNOWN_ERROR = -99;
    public const SUCCESS = 1;
}

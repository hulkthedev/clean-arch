<?php

namespace App\Usecase;

class ResultCodes
{
    public const UNKNOWN_ERROR = -99;

    /** logic */
    public const CONTRACT_TERMINATED = -25;
    public const CONTRACT_FINISHED = -24;
    public const CONTRACT_INACTIVE = -23;
    public const RISKS_NOT_FOUND = -22;
    public const OBJECT_NOT_FOUND = -21;
    public const CONTRACT_NOT_FOUND = -20;

    /** database */
    public const DATABASE_UNREACHABLE = -10;

    /** validation */
    public const INVALID_JSON_CONTENT = -3;
    public const INVALID_MEDIA_TYPE = -2;
    public const INVALID_SYNTAX = -1;

    /** success */
    public const SUCCESS = 1;
}

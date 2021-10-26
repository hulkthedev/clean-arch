<?php

namespace App\Usecase;

class ResultCodes
{
    public const UNKNOWN_ERROR = -99;


    /** book risks logic */
    public const RISK_TYPE_ERROR = -44;
    public const RISK_TYPE_NOT_FOUND = -43;
    public const OBJECT_ALREADY_TERMINATED = -42;
    public const OBJECT_ALREADY_FINISHED = -41;

    /** termination logic */
    public const CONTRACT_TERMINATION_ERROR = -34;
    public const CONTRACT_TERMINATION_IN_THE_PAST = -33;
    public const CONTRACT_ALREADY_TERMINATED = -32;
    public const CONTRACT_ALREADY_FINISHED = -31;
    public const CONTRACT_ALREADY_INACTIVE = -30;

    /** not found */
    public const RISKS_NOT_FOUND = -22;
    public const OBJECT_NOT_FOUND = -21;
    public const CONTRACT_NOT_FOUND = -20;

    /** database */
    public const DATABASE_UNREACHABLE = -10;

    /** validation */
    public const MISSING_PARAMETER = -2;
    public const INVALID_SYNTAX = -1;

    /** success */
    public const SUCCESS = 1;
}

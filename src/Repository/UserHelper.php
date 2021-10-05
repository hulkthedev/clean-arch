<?php

namespace App\Repository;

use App\Entity\User;

trait UserHelper
{
    /**
     * @param User $user
     * @return array
     */
    public function getChangedData(User $user): array
    {
        $changedData = [];
        foreach ($user as $prop => $value) {
            if (!empty($value)) {
                $changedData[$prop] = $value;
            }
        }

        return $changedData;
    }

    /**
     * @param array $changedData
     * @return string
     */
    public function getChangedDataSQLStatement(array $changedData): string
    {
        $sqlStatement = '';
        foreach ($changedData as $key => $value) {
            $sqlStatement .= "$key=:$key,";
        }

        return rtrim($sqlStatement, ',');
    }
}

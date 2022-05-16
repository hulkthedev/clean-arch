<?php

namespace App\Mapper;

interface Mapper
{
    public function mapToList(array $userList): array;
}

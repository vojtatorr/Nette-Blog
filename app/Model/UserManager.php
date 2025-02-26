<?php

declare(string_types=1);

namespace App\Model;

class UseManager extends BaseMangar
{
    public function getTableName(): string
    {
        return "user";
    }
}
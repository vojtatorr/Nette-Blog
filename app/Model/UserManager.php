<?php

declare(string_types=1);

namespace App\Model;

class UseManager extends BaseMangar
{
    public function getTableName(): string
    {
        return "user";
    }

    public function getByEmail(): ?ActiveRow
    {
        return $this->getAll()
            ->where("email", $email)
            ->fetch();
    }
}
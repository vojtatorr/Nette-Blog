<?php

declare(strict_types=1);

namespace App\Model;

class UserManager extends BaseManager
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
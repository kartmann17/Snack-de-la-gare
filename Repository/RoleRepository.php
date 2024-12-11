<?php

namespace App\Repository;


class RoleRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Role";
    }
}
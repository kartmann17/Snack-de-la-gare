<?php

namespace App\Repository;

class BurgersRepository extends Repository
{

    public function __construct()
    {
        $this->table = "burgers";
    }

}
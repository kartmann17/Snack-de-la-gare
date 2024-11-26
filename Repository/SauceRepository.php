<?php

namespace App\Repository;

class SauceRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Sauces";
    }

}
<?php

namespace App\Repository;

class PizzaRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Pizza";
    }
}



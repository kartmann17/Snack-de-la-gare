<?php

namespace App\Repository;

class TacosRepository extends Repository
{

    public function __construct()
    {
        $this->table = "Tacos";
    }

}
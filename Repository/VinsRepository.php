<?php

namespace App\Repository;

class VinsRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Nos_Vins";
    }

}
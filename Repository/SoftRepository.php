<?php

namespace App\Repository;

class SoftRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Nos_Soft";
    }

}
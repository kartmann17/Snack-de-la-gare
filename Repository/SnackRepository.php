<?php

namespace App\Repository;

class SnackRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Nos_Snacks";
    }

}
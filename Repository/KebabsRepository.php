<?php

namespace App\Repository;

class KebabsRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Kebabs";
    }

}
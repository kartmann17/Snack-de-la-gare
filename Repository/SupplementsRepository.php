<?php

namespace App\Repository;

class SupplementsRepository extends Repository{

    public function __construct(){
        $this->table = "Supplements";
    }
}
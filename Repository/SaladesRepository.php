<?php

namespace App\Repository;

class SaladesRepository extends MongoRepository
{
    public function table($data): string
    {
        return $this->create("Nos_Salades",$data);
    }

}
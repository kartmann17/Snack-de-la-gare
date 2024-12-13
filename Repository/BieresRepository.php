<?php

namespace App\Repository;
class BieresRepository extends MongoRepository
{
    public function table($data): string
    {
        return $this->create("Nos_Bieres",$data);
    }


}
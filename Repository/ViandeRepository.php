<?php

namespace App\Repository;

class ViandeRepository extends MongoRepository
{
    public function table($data): string
    {
        return $this->create("Viandes",$data);
    }

}
<?php

namespace App\Repository;

class BurgersRepository extends MongoRepository
{

    public function table($data): string
    {
        return $this->create("burgers",$data);
    }

}
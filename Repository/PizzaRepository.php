<?php

namespace App\Repository;

class PizzaRepository extends MongoRepository
{
    public function table($data): string
    {
        return $this->create("Pizza", $data);
    }
}



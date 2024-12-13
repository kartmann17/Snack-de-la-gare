<?php

namespace App\Repository;

class SauceRepository extends MongoRepository
{
    public function table($data): string
    {
        return $this->create("Sauces", $data);
    }

}
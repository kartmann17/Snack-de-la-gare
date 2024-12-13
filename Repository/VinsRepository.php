<?php

namespace App\Repository;

class VinsRepository extends MongoRepository
{
    public function table($data)
    {
        return $this->create("Nos_Vins", $data);
    }
}

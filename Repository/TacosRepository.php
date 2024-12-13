<?php

namespace App\Repository;

class TacosRepository extends MongoRepository
{

    public function table($data)
    {
       return $this->create("Tacos", $data);
    }

}
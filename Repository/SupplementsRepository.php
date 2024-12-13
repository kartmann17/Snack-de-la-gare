<?php

namespace App\Repository;

class SupplementsRepository extends MongoRepository{

    public function table($data)
    {
       return $this->create("Supplements", $data);
    }
}
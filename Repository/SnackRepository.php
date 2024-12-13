<?php

namespace App\Repository;

class SnackRepository extends MongoRepository
{
    public function table($data)
    {
       return $this->create("Nos_Snacks", $data);
    }

}
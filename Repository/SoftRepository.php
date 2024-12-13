<?php

namespace App\Repository;

class SoftRepository extends MongoRepository
{
    public function table($data): string
    {
       return $this->create("Nos_Soft", $data);
    }

}
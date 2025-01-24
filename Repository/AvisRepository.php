<?php

namespace App\Repository;

class AvisRepository extends MongoRepository
{
    public function table($data)
    {
        return $this->create('avis', $data);
    }

}

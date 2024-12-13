<?php

namespace App\Repository;

class HoraireRepository extends MongoRepository
{

    public function table($data)
    {

        return $this->create('horaire', $data);
    }

}

<?php

namespace App\Repository;

class KebabsRepository extends MongoRepository
{
    public function table($data): string
    {

        return $this->create("kebabs", $data);
    }
}

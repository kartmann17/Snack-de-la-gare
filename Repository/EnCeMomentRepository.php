<?php

namespace App\Repository;

class EnCeMomentRepository extends MongoRepository
{

    public function table($data): string
    {
        return $this->create("En_ce_moments",$data);
    }
}
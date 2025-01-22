<?php

namespace App\Services;

use App\Repository\VinsRepository;

class VinsService
{
    private $vinsRepository;

    public function __construct()
    {
        $this->vinsRepository = new VinsRepository();
    }

    public function addVin(array $data): bool
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->create($alias, $data);
    }

    public function updateVin(string $id, array $data): bool
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteVin(string $id): bool
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getVinById(string $id): ?array
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->find($alias, $id);
    }

    public function getAllVins(): array
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->findAll($alias);
    }
}
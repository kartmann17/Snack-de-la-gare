<?php

namespace App\Services;

use App\Repository\ViandeRepository;

class ViandeService
{
    private $viandeRepository;

    public function __construct()
    {
        $this->viandeRepository = new ViandeRepository();
    }

    public function addViande(array $data): bool
    {
        $alias = 'Viandes';
        return $this->viandeRepository->create($alias, $data);
    }

    public function updateViande(string $id, array $data): bool
    {
        $alias = 'Viandes';
        return $this->viandeRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteViande(string $id): bool
    {
        $alias = 'Viandes';
        return $this->viandeRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getViandeById(string $id): ?array
    {
        $alias = 'Viandes';
        return $this->viandeRepository->find($alias, $id);
    }

    public function getAllViandes(): array
    {
        $alias = 'Viandes';
        return $this->viandeRepository->findAll($alias);
    }
}
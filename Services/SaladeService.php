<?php

namespace App\Services;

use App\Repository\SaladesRepository;

class SaladeService
{
    private $saladesRepository;

    public function __construct()
    {
        $this->saladesRepository = new SaladesRepository();
    }

    public function addSalade(array $data): bool
    {
        $alias = 'Nos_Salades';
        return $this->saladesRepository->create($alias, $data);
    }

    public function updateSalade(string $id, array $data): bool
    {
        $alias = 'Nos_Salades';
        return $this->saladesRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSalade(string $id): bool
    {
        $alias = 'Nos_Salades';
        return $this->saladesRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSaladeById(string $id): ?array
    {
        $alias = 'Nos_Salades';
        return $this->saladesRepository->find($alias, $id);
    }

    public function getAllSalades(): array
    {
        $alias = 'Nos_Salades';
        return $this->saladesRepository->findAll($alias);
    }
}
<?php

namespace App\Services;

use App\Repository\BieresRepository;


class BieresService
{
    private $bieresRepository;

    public function __construct()
    {
        $this->bieresRepository = new BieresRepository();
    }

    public function addBiere(array $data): bool
    {
        $alias = 'Nos_Bieres';
        return $this->bieresRepository->create($alias, $data);
    }

    public function updateBiere(string $id, array $data): bool
    {
        $alias = 'Nos_Bieres';
        return $this->bieresRepository->update($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)], $data) > 0;
    }

    public function deleteBiere(string $id): bool
    {
        $alias = 'Nos_Bieres';
        return $this->bieresRepository->delete($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)]) > 0;
    }

    public function findBiereById(string $id): ?array
    {
        $alias = 'Nos_Bieres';
        return $this->bieresRepository->find($alias, $id);
    }

    public function getAllBieres(): array
    {
        $alias = 'Nos_Bieres';
        return $this->bieresRepository->findAll($alias);
    }
}
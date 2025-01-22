<?php

namespace App\Services;

use App\Repository\SauceRepository;

class SaucesService
{
    private $sauceRepository;

    public function __construct()
    {
        $this->sauceRepository = new SauceRepository();
    }

    public function addSauce(array $data): bool
    {
        $alias = 'Sauces';
        return $this->sauceRepository->create($alias, $data);
    }

    public function updateSauce(string $id, array $data): bool
    {
        $alias = 'Sauces';
        return $this->sauceRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSauce(string $id): bool
    {
        $alias = 'Sauces';
        return $this->sauceRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSauceById(string $id): ?array
    {
        $alias = 'Sauces';
        return $this->sauceRepository->find($alias, $id);
    }

    public function getAllSauces(): array
    {
        $alias = 'Sauces';
        return $this->sauceRepository->findAll($alias);
    }
}
<?php

namespace App\Services;

use App\Repository\SnackRepository;

class SnackService
{
    private $snackRepository;

    public function __construct()
    {
        $this->snackRepository = new SnackRepository();
    }

    public function addSnack(array $data): bool
    {
        $alias = 'Nos_Snacks';
        return $this->snackRepository->create($alias, $data);
    }

    public function updateSnack(string $id, array $data): bool
    {
        $alias = 'Nos_Snacks';
        return $this->snackRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSnack(string $id): bool
    {
        $alias = 'Nos_Snacks';
        return $this->snackRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSnackById(string $id): ?array
    {
        $alias = 'Nos_Snacks';
        return $this->snackRepository->find($alias, $id);
    }

    public function getAllSnacks(): array
    {
        $alias = 'Nos_Snacks';
        return $this->snackRepository->findAll($alias);
    }
}
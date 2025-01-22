<?php

namespace App\Services;

use App\Repository\SupplementsRepository;

class SupplementService
{
    private $supplementsRepository;

    public function __construct()
    {
        $this->supplementsRepository = new SupplementsRepository();
    }

    public function addSupplement(array $data): bool
    {
        $alias = 'Supplements';
        return $this->supplementsRepository->create($alias, $data);
    }

    public function updateSupplement(string $id, array $data): bool
    {
        $alias = 'Supplements';
        return $this->supplementsRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSupplement(string $id): bool
    {
        $alias = 'Supplements';
        return $this->supplementsRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSupplementById(string $id): ?array
    {
        $alias = 'Supplements';
        return $this->supplementsRepository->find($alias, $id);
    }

    public function getAllSupplements(): array
    {
        $alias = 'Supplements';
        return $this->supplementsRepository->findAll($alias);
    }
}
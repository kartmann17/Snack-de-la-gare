<?php

namespace App\Services;

use App\Repository\SoftRepository;

class SoftService
{
    private $softRepository;

    public function __construct()
    {
        $this->softRepository = new SoftRepository();
    }

    public function addSoft(array $data): bool
    {
        $alias = 'Nos_Soft';
        return $this->softRepository->create($alias, $data);
    }

    public function updateSoft(string $id, array $data): bool
    {
        $alias = 'Nos_Soft';
        return $this->softRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSoft(string $id): bool
    {
        $alias = 'Nos_Soft';
        return $this->softRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSoftById(string $id): ?array
    {
        $alias = 'Nos_Soft';
        return $this->softRepository->find($alias, $id);
    }

    public function getAllSofts(): array
    {
        $alias = 'Nos_Soft';
        return $this->softRepository->findAll($alias);
    }
}
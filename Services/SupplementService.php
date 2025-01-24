<?php

namespace App\Services;

use App\Models\SupplementsModel;
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
        $data = [
            'nom' => $data['nom']
        ];

        $supplementModel = new SupplementsModel();
        $supplementModel->hydrate($data);


        $alias = 'Supplements';
        $supplementsRepository = new SupplementsRepository();
        return $supplementsRepository->create($alias, $data);
    }

    public function updateSupplement(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom']
        ];

        $alias = 'Supplements';
        $supplementsRepository = new SupplementsRepository();
        return $supplementsRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSupplement(string $id): bool
    {
        $alias = 'Supplements';
        $supplement = $this->supplementsRepository->find($alias, $id);

        if (!$supplement) {
            return false;
        }

        $supplementsRepository = new SupplementsRepository();
        return $supplementsRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSupplementById(string $id): ?array
    {
        $alias = 'Supplements';
        $supplementsRepository = new SupplementsRepository();
        return $supplementsRepository->find($alias, $id);
    }

    public function getAllSupplements(): array
    {
        $alias = 'Supplements';
        $supplementsRepository = new SupplementsRepository();
        return $supplementsRepository->findAll($alias);
    }
}
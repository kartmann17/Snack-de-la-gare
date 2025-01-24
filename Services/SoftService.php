<?php

namespace App\Services;

use App\Repository\SoftRepository;
use App\Models\SoftsModel;

class SoftService
{
    private $softRepository;

    public function __construct()
    {
        $this->softRepository = new SoftRepository();
    }

    public function addSoft(array $data): bool
    {

        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
        ];

        // Hydrate le modèle
        $softsModel = new SoftsModel();
        $softsModel->hydrate($data);

        $alias = 'Nos_Soft';
        $softRepository = new SoftRepository();
        return $softRepository->create($alias, $data);
    }

    public function updateSoft(string $id, array $data): bool
    {
        // Préparation des données
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
        ];

        $alias = 'Nos_Soft';
        $softRepository = new SoftRepository();
        return $softRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSoft(string $id): bool
    {

        $alias = 'Nos_Soft';
        $soft = $this->softRepository->find($alias, $id);

        if (!$soft) {
            return false;
        }

        $softRepository = new SoftRepository();
        return $softRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function findSoftById(string $id): ?array
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
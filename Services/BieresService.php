<?php

namespace App\Services;

use App\Repository\BieresRepository;
use App\Models\BieresModel;

class BieresService
{
    private $bieresRepository;

    public function __construct()
    {
        $this->bieresRepository = new BieresRepository();
    }

    public function addBiere(array $data): bool
    {
        // Préparation des données
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
        ];

        // Hydrate le modèle
        $bieresModel = new BieresModel();
        $bieresModel->hydrate($data);

        $alias = 'Nos_Bieres';
        $bieresRepository = new BieresRepository();
        return $bieresRepository->create($alias, $data);
    }

    public function updateBiere(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
        ];

        $alias = 'Nos_Bieres';
        $bieresRepository = new BieresRepository();
        return $bieresRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteBiere(string $id): bool
    {

        $alias = 'Nos_Bieres';
        $biere = $this->bieresRepository->find($alias, $id);

        if (!$biere) {
            return false;
        }

        $bieresRepository = new BieresRepository();
        return $bieresRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function findBiereById(string $id): ?array
    {
        $alias = 'Nos_Bieres';
        $bieresRepository = new BieresRepository();
        return $bieresRepository->find($alias, $id);
    }

    public function getAllBieres(): array
    {
        $alias = 'Nos_Bieres';
        $bieresRepository = new BieresRepository();
        return $bieresRepository->findAll($alias);
    }
}
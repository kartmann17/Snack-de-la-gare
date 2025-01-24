<?php

namespace App\Services;

use App\Repository\VinsRepository;
use App\Models\VinsModel;

class VinsService
{
    private $vinsRepository;

    public function __construct()
    {
        $this->vinsRepository = new VinsRepository();
    }

    public function addVins(array $data): bool
    {
        // Préparation des données
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
        ];

        // Hydrate le modèle
        $vinsModel = new VinsModel();
        $vinsModel->hydrate($data);

        $alias = 'Nos_Vins';
        $vinsRepository = new VinsRepository();
        return $vinsRepository->create($alias, $data);
    }

    public function updateVins(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
        ];

        $alias = 'Nos_Vins';
        $vinsRepository = new VinsRepository();
        return $vinsRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteVins(string $id): bool
    {
        $alias = 'Nos_Vins';
        $vin = $this->vinsRepository->find($alias, $id);

        if (!$vin) {
            return false;
        }

        $vinsRepository = new VinsRepository();
        return $vinsRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getVinsById(string $id): ?array
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->find($alias, $id);
    }

    public function getAllVins(): array
    {
        $alias = 'Nos_Vins';
        return $this->vinsRepository->findAll($alias);
    }
}
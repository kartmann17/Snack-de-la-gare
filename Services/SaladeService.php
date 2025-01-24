<?php

namespace App\Services;

use App\Models\SaladesModel;
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
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
            'description' => $data['description'],
        ];

        $saladesModel = new SaladesModel();
        $saladesModel->hydrate($data);

        $alias = 'Nos_Salades';
        $saladesRepository = new SaladesRepository();
        return $saladesRepository->create($alias, $data);
    }

    public function updateSalade(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
            'description' => $data['description'],
        ];
        $saladesModel = new SaladesModel();
        $saladesModel->hydrate($data);
        $alias = 'Nos_Salades';

        $saladesRepository = new SaladesRepository();
        return $saladesRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSalade(string $id): bool
    {
        $alias = 'Nos_Salades';
        $salade = $this->saladesRepository->find($alias, $id);
        if (!$salade) {
            return false;
        }
        $saladesRepository = new SaladesRepository();
        return $saladesRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSaladeById(string $id): ?array
    {
        $alias = 'Nos_Salades';
        $saladesRepository = new SaladesRepository();
        return $saladesRepository->find($alias, $id);
    }

    public function getAllSalades(): array
    {
        $alias = 'Nos_Salades';
        $saladesRepository = new SaladesRepository();
        return $saladesRepository->findAll($alias);
    }
}

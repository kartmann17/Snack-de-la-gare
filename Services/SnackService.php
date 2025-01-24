<?php

namespace App\Services;

use App\Models\SnacksModel;
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
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
            'description' => $data['description']
        ];

        $snacksModel = new SnacksModel();
        $snacksModel->hydrate($data);

        $alias = 'Nos_Snacks';
        $snackRepository = new SnackRepository();
        return $snackRepository->create($alias, $data);
    }

    public function updateSnack(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
            'description' => $data['description']
        ];

        $snacksModel = new SnacksModel();
        $snacksModel->hydrate($data);
        $alias = 'Nos_Snacks';

        $snackRepository = new SnackRepository();
        return $snackRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSnack(string $id): bool
    {
        $alias = 'Nos_Snacks';
        $snack = $this->snackRepository->find($alias, $id);
        if (!$snack) {
            return false;
        }
        $snackRepository = new SnackRepository();
        return $snackRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSnackById(string $id): ?array
    {
        $alias = 'Nos_Snacks';
        $snackRepository = new SnackRepository();
        return $snackRepository->find($alias, $id);
    }

    public function getAllSnacks(): array
    {
        $alias = 'Nos_Snacks';
        $snackRepository = new SnackRepository();
        return $snackRepository->findAll($alias);
    }
}

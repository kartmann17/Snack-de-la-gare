<?php

namespace App\Services;

use App\Repository\ViandeRepository;
use App\Models\ViandeModel;

class ViandeService
{
    private $viandeRepository;

    public function __construct()
    {
        $this->viandeRepository = new ViandeRepository();
    }

    public function addViande(array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
        ];

        $viandeModel = new ViandeModel();
        $viandeModel->hydrate($data);

        $alias = 'Viandes';
        $viandeRepository = new ViandeRepository();
        return $viandeRepository->create($alias, $data);
    }

    public function updateViande(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
        ];

        $alias = 'Viandes';
        $viandeRepository = new ViandeRepository();
        return $viandeRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteViande(string $id): bool
    {
        $alias = 'Viandes';
        $viande = $this->viandeRepository->find($alias, $id);

        if (!$viande) {
            return false;
        }

        $viandeRepository = new ViandeRepository();
        return $viandeRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function findViandeById(string $id): ?array
    {
        $alias = 'Viandes';
        return $this->viandeRepository->find($alias, $id);
    }

    public function getAllViandes(): array
    {
        $alias = 'Viandes';
        return $this->viandeRepository->findAll($alias);
    }
}

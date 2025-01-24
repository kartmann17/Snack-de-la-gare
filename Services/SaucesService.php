<?php

namespace App\Services;

use App\Repository\SauceRepository;
use App\Models\SauceModel;

class SaucesService
{
    private $sauceRepository;

    public function __construct()
    {
        $this->sauceRepository = new SauceRepository();
    }

    public function addSauce(array $data): bool
    {
        $data = [
            'nom' => $data['nom']
        ];


        $sauceModel = new SauceModel($data);
        $sauceModel->hydrate($data);

        $alias = 'Sauces';
        $sauceRepository = new SauceRepository();
        return $sauceRepository->create($alias, $data);
    }

    public function updateSauce(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom']
        ];
        $sauceModel = new SauceModel($data);
        $sauceModel->hydrate($data);
        $alias = 'Sauces';

        $sauceRepository = new SauceRepository();
        return $sauceRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteSauce(string $id): bool
    {
        $alias = 'Sauces';
        $sauce = $this->sauceRepository->find($alias, $id);
        if (!$sauce) {
            return false;
        }
        $sauceRepository = new SauceRepository();
        return $sauceRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getSauceById(string $id): ?array
    {
        $alias = 'Sauces';
        $sauceRepository = new SauceRepository();
        return $sauceRepository->find($alias, $id);
    }

    public function getAllSauces(): array
    {
        $alias = 'Sauces';
        $sauceRepository = new SauceRepository();
        return $sauceRepository->findAll($alias);
    }
}

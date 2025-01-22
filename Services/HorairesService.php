<?php

namespace App\Services;

use App\Repository\HoraireRepository;

class HorairesService
{
    private $horaireRepository;

    public function __construct()
    {
        $this->horaireRepository = new HoraireRepository();
    }

    public function addHoraire(array $data): bool
    {
        $alias = 'horaire';
        return $this->horaireRepository->create($alias, $data);
    }

    public function updateHoraire(string $id, array $data): bool
    {
        $alias = 'horaire';
        return $this->horaireRepository->update($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)], $data) > 0;
    }

    public function deleteHoraire(string $id): bool
    {
        $alias = 'horaire';
        $horaire = $this->horaireRepository->find($alias, $id);

        if ($horaire) {
            return $this->horaireRepository->delete($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)]) > 0;
        }

        return false;
    }

    public function getHoraireById(string $id): ?array
    {
        $alias = 'horaire';
        return $this->horaireRepository->find($alias, $id);
    }

    public function getAllHoraires(): array
    {
        $alias = 'horaire';
        return $this->horaireRepository->findBy($alias, [], ['sort' => ['_id' => 1]]);
    }
}
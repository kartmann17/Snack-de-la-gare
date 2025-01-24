<?php

namespace App\Services;

use App\Models\HorairesModel;
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
        $data = [
            'jour' => $data['jour'],
            'ouverture_M' => $data['ouverture_M'],
            'ouverture_S' => $data['ouverture_S']
        ];

        $horairesModel = new HorairesModel();
        $horairesModel->hydrate($data);

        $alias = 'horaire';
        $horaireRepository = new HoraireRepository();
        return $horaireRepository->create($alias, $data);
    }

    public function updateHoraire(string $id, array $data): bool
    {
        $data = [
            'jour' => $data['jour'],
            'ouverture_M' => $data['ouverture_M'],
            'ouverture_S' => $data['ouverture_S']
        ];

        $alias = 'horaire';
        $horaireRepository = new HoraireRepository();
        return $horaireRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteHoraire(string $id): bool
    {
        $alias = 'horaire';
        $horaire = $this->horaireRepository->find($alias, $id);

        if (!$horaire) {
            return false;
        }
        $horaireRepository = new HoraireRepository();
        return $horaireRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getHoraireById(string $id): ?array
    {
        $alias = 'horaire';
        $horaireRepository = new HoraireRepository();
        return $horaireRepository->find($alias, $id);
    }

    public function getAllHoraires(): array
    {
        $alias = 'horaire';
        $horaireRepository = new HoraireRepository();
        return $horaireRepository->findBy($alias, [], ['sort' => ['_id' => 1]]);
    }
}

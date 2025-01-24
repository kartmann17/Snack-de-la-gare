<?php

namespace App\Services;

use App\Repository\AvisRepository;

class ValideAvisService
{
    private $avisRepository;

    public function __construct()
    {
        $this->avisRepository = new AvisRepository();
    }

    public function getNonValides(): array
    {
        return $this->avisRepository->findBy('avis', ['valide' => 0]);
    }

    public function getAllAvis(): array
    {
        return $this->avisRepository->findAll('avis');
    }

    public function deleteAvis(string $id): bool
    {
        $avis = $this->avisRepository->find('avis', $id);

        if (!$avis) {
            return false;
        }

        return $this->avisRepository->delete(
            'avis',
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function validerAvis(string $id): bool
    {
        $criteria = ['_id' => new \MongoDB\BSON\ObjectId($id)];
        $update = ['valide' => 1];

        return $this->avisRepository->update('avis', $criteria, $update) > 0;
    }

    public function saveAvis(array $data): bool
{

    $data = [
        'etoiles' => filter_var($data['etoiles'] ?? '', FILTER_SANITIZE_NUMBER_INT),
        'nom' => htmlspecialchars(trim($data['nom'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'commentaire' => htmlspecialchars(trim($data['commentaire'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'valide' => 0
    ];

    if (empty($data['etoiles']) || empty($data['nom']) || empty($data['commentaire'])) {
        return false;
    }

    return $this->avisRepository->create('avis', $data);
}
}
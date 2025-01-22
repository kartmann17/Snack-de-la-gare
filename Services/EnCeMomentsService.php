<?php

namespace App\Services;

use App\Repository\EnCeMomentRepository;
use App\Services\CloudinaryService;

class EnCeMomentsService
{
    private $enCeMomentRepository;
    private $cloudinaryService;

    public function __construct()
    {
        $this->enCeMomentRepository = new EnCeMomentRepository();
        $this->cloudinaryService = new CloudinaryService();
    }

    public function addEnCeMoment(array $data, ?string $imgPath): bool
    {
        $data['img'] = $imgPath;
        $alias = 'En_ce_moments';
        return $this->enCeMomentRepository->create($alias, $data);
    }

    public function deleteEnCeMoment(string $id): bool
    {
        $alias = 'En_ce_moments';
        $record = $this->enCeMomentRepository->find($alias, $id);

        if ($record) {
            // Supprimer l'image associée sur Cloudinary
            $publicId = pathinfo($record['img'], PATHINFO_FILENAME);
            $this->cloudinaryService->deleteFile($publicId);

            // Supprimer l'enregistrement de la base
            return $this->enCeMomentRepository->delete($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)]) > 0;
        }

        return false;
    }

    public function getAllEnCeMoments(): array
    {
        $alias = 'En_ce_moments';
        return $this->enCeMomentRepository->findAll($alias);
    }

    public function getEnCeMomentById(string $id): ?array
    {
        $alias = 'En_ce_moments';
        return $this->enCeMomentRepository->find($alias, $id);
    }

    public function getCloudinaryService(): CloudinaryService
    {
        return $this->cloudinaryService;
    }
}
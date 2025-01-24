<?php

namespace App\Services;

use App\Repository\EnCeMomentRepository;
use App\Services\CloudinaryService;
use App\Models\EnCeMomentModel;

class EnCeMomentsService
{
    private $enCeMomentRepository;

    public function __construct()
    {
        $this->enCeMomentRepository = new EnCeMomentRepository();
    }

    public function addEnCeMoment(array $data): bool
{
    $imgs = new CloudinaryService();

    $img = $imgs->validateAndUploadImage($_FILES['img']);
    if (!$img) {
        return false;
    }

    $data['img'] = $img;

    $encemomentModel = new EnCeMomentModel();
    $encemomentModel->hydrate($data);

    $alias = 'En_ce_moments';
    $enCeMomentRepository = new EnCeMomentRepository();
    return $enCeMomentRepository->create($alias, $data);
}

    public function deleteEnCeMoment(string $id): bool
    {
        $alias = 'En_ce_moments';
        $record = $this->enCeMomentRepository->find($alias, $id);

        if ($record) {
            return false;
        }
        if (!empty($record['img'])) {
            $cloudinaryService = new CloudinaryService();
            $publicId = pathinfo($record['img'], PATHINFO_FILENAME);
            if (!$cloudinaryService->deleteFile($publicId)) {
                error_log("Échec de la suppression de l'image sur Cloudinary pour : $id");
            }
        }
        $enCeMomentRepository = new EnCeMomentRepository();
        return $enCeMomentRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        )
            > 0;
    }

    public function getAllEnCeMoments(): array
    {
        $alias = 'En_ce_moments';
        $enCeMomentRepository = new EnCeMomentRepository();
        return $enCeMomentRepository->findAll($alias);
    }

    public function getEnCeMomentById(string $id): ?array
    {
        $alias = 'En_ce_moments';
        $enCeMomentRepository = new EnCeMomentRepository();
        return $enCeMomentRepository->find($alias, $id);
    }
}

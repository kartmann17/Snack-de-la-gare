<?php

namespace App\Services;

use App\Repository\KebabsRepository;
use App\Services\CloudinaryService;

class KebabsService
{
    private $kebabsRepository;
    private $cloudinaryService;

    public function __construct()
    {
        $this->kebabsRepository = new KebabsRepository();
        $this->cloudinaryService = new CloudinaryService();
    }

    public function addKebab(array $data, ?string $imgPath): bool
    {
        $data['img'] = $imgPath;
        $alias = 'kebabs';
        return $this->kebabsRepository->create($alias, $data);
    }

    public function updateKebab(string $id, array $data, ?string $imgPath): bool
    {
        $data['img'] = $imgPath;
        $alias = 'kebabs';
        return $this->kebabsRepository->update($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)], $data) > 0;
    }

    public function deleteKebab(string $id): bool
    {
        $alias = 'kebabs';
        $kebab = $this->kebabsRepository->find($alias, $id);

        if ($kebab) {
            // Supprimer l'image associée sur Cloudinary
            $publicId = pathinfo($kebab['img'], PATHINFO_FILENAME);
            $this->cloudinaryService->deleteFile($publicId);

            // Supprimer l'enregistrement de la base
            return $this->kebabsRepository->delete($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)]) > 0;
        }

        return false;
    }

    public function getKebabById(string $id): ?array
    {
        $alias = 'kebabs';
        return $this->kebabsRepository->find($alias, $id);
    }

    public function getAllKebabs(): array
    {
        $alias = 'kebabs';
        return $this->kebabsRepository->findAll($alias);
    }

    public function getCloudinaryService(): CloudinaryService
    {
        return $this->cloudinaryService;
    }
}
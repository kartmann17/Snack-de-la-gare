<?php

namespace App\Services;

use App\Repository\BurgersRepository;
use App\Services\CloudinaryService;

class BurgersService
{
    private $burgersRepository;
    private $cloudinaryService;

    public function __construct()
    {
        $this->burgersRepository = new BurgersRepository();
        $this->cloudinaryService = new CloudinaryService(); // Initialisation de CloudinaryService
    }

    public function addBurger(array $data, ?string $imgPath): bool
    {
        $data['img'] = $imgPath;
        $alias = 'burgers';
        return $this->burgersRepository->create($alias, $data);
    }

    public function updateBurger(string $id, array $data, ?string $imgPath): bool
    {
        $data['img'] = $imgPath;
        $alias = 'burgers';
        return $this->burgersRepository->update($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)], $data) > 0;
    }

    public function deleteBurger(string $id): bool
    {
        $alias = 'burgers';
        $burger = $this->burgersRepository->find($alias, $id);

        if ($burger) {
            // Supprimer l'image associée sur Cloudinary
            $publicId = pathinfo($burger['img'], PATHINFO_FILENAME);
            $this->cloudinaryService->deleteFile($publicId);

            // Supprimer le burger de la base
            return $this->burgersRepository->delete($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)]) > 0;
        }

        return false;
    }

    public function getBurgerById(string $id): ?array
    {
        $alias = 'burgers';
        return $this->burgersRepository->find($alias, $id);
    }

    public function getAllBurgers(): array
    {
        $alias = 'burgers';
        return $this->burgersRepository->findAll($alias);
    }

    public function getCloudinaryService(): CloudinaryService
    {
        return $this->cloudinaryService;
    }
}
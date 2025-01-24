<?php

namespace App\Services;

use App\Repository\BurgersRepository;
use App\Services\CloudinaryService;
use App\Models\BurgersModel;

class BurgersService
{
    private $burgersRepository;

    public function __construct()
    {
        $this->burgersRepository = new BurgersRepository();
    }

    public function addBurger(array $data): bool
    {
        // Instance du service Cloudinary
        $imgs = new CloudinaryService;
        $img = $imgs->validateAndUploadImage($_FILES['img']);
        $data = [
            'nom' => $data['nom'],
            'solo' => $data['solo'],
            'menu' => $data['menu'],
            'description' => $data['description'],
            'img' => $img,
        ];

        $burgersModel = new BurgersModel();
        $burgersModel->hydrate($data);

        $alias = 'burgers';
        $burgersRepository = new burgersRepository();
        return $burgersRepository->create($alias, $data);
    }

    public function updateBurger(string $id, array $data): bool
{
    $cloudinaryService = new CloudinaryService();

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $existingBurger = $this->getBurgerById($id);

        if ($existingBurger && !empty($existingBurger['img'])) {
            $publicId = pathinfo($existingBurger['img'], PATHINFO_FILENAME);
            if (!$cloudinaryService->deleteFile($publicId)) {
                return false;
            }
        }

        $imgPath = $cloudinaryService->validateAndUploadImage($_FILES['img']);
        if (!$imgPath) {
            return false;
        }

        $data['img'] = $imgPath;
    } else {
        $existingBurger = $this->getBurgerById($id);
        if ($existingBurger) {
            $data['img'] = $existingBurger['img'];
        } else {
            return false;
        }
    }
    $data = [
        'nom' => $data['nom'],
        'solo' => $data['solo'],
        'menu' => $data['menu'],
        'description' => $data['description'],
        'img' => $data['img'],
    ];

    $burgersModel = new BurgersModel();
    $burgersModel->hydrate($data);
    $alias = 'burgers';

    $burgersRepository = new BurgersRepository();
    return $burgersRepository->update(
        $alias,
        ['_id' => new \MongoDB\BSON\ObjectId($id)],
        $data
    ) > 0;
}

public function deleteBurger(string $id): bool
{
    $alias = 'burgers';
    $burger = $this->burgersRepository->find($alias, $id);

    if (!$burger) {
        return false;
    }
    if (!empty($burger['img'])) {
        $cloudinaryService = new CloudinaryService();
        $publicId = pathinfo($burger['img'], PATHINFO_FILENAME);
        if (!$cloudinaryService->deleteFile($publicId)) {
            error_log("Échec de la suppression de l'image sur Cloudinary pour le burger ID : $id");
        }
    }
    $burgersRepository = new BurgersRepository();
    return $burgersRepository->delete(
        $alias,
        ['_id' => new \MongoDB\BSON\ObjectId($id)]
    ) > 0;
}

    public function getBurgerById(string $id): ?array
    {
        $alias = 'burgers';
        $burgersRepository = new BurgersRepository();
        return $burgersRepository->find($alias, $id);
    }

    public function getAllBurgers(): array
    {
        $alias = 'burgers';
        $burgersRepository = new BurgersRepository();
        return $burgersRepository->findAll($alias);
    }
}

<?php

namespace App\Services;

use App\Repository\KebabsRepository;
use App\Services\CloudinaryService;
use App\Models\KebabsModel;

class KebabsService
{
    private $kebabsRepository;
    private $cloudinaryService;

    public function __construct()
    {
        $this->kebabsRepository = new KebabsRepository();
    }

    public function addKebab(array $data): bool
    {
        // Instance du service Cloudinary
        $imgs = new CloudinaryService;
        $img = $imgs->validateAndUploadImage($_FILES['img']);
        $data = [
            'nom' => $data['nom'],
            'solo' => $data['solo'],
            'menu' => $data['menu'],
            'assiette' => $data['assiette'],
            'description' => $data['description'],
            'img' => $img,
        ];

        $kebabsModel = new KebabsModel();
        $kebabsModel->hydrate($data);

        $alias = 'kebabs';
        $kebabsRepository = new KebabsRepository();
        return $kebabsRepository->create($alias, $data);
    }

    public function updateKebab(string $id, array $data): bool
    {
        $cloudinaryService = new CloudinaryService();

        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $existingKebab = $this->getKebabById($id);

            if ($existingKebab && !empty($existingKebab['img'])) {
                $publicId = pathinfo($existingKebab['img'], PATHINFO_FILENAME);
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
            $existingKebab = $this->getKebabById($id);
            if ($existingKebab) {
                $data['img'] = $existingKebab['img'];
            } else {
                return false;
            }
        }
        $data = [
            'nom' => $data['nom'],
            'solo' => $data['solo'],
            'menu' => $data['menu'],
            'assiette' => $data['assiette'],
            'description' => $data['description'],
            'img' => $data['img'],
        ];

        $kebabsModel = new KebabsModel();
        $kebabsModel->hydrate($data);

        $alias = 'kebabs';
        return $this->kebabsRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteKebab(string $id): bool
    {
        $alias = 'kebabs';
        $kebab = $this->kebabsRepository->find($alias, $id);

        if (!$kebab) {
            return false;
        }
        if (!empty($kebab['img'])) {
            $cloudinaryService = new CloudinaryService();
            $publicId = pathinfo($kebab['img'], PATHINFO_FILENAME);
            if (!$cloudinaryService->deleteFile($publicId)) {
                error_log("Échec de la suppression de l'image sur Cloudinary pour le kebab ID : $id");
            }
        }


        $kebabsRepository = new KebabsRepository();
        return $kebabsRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getKebabById(string $id): ?array
    {
        $alias = 'kebabs';
        $kebabsRepository = new KebabsRepository();
        return $kebabsRepository->find($alias, $id);
    }

    public function getAllKebabs(): array
    {
        $alias = 'kebabs';
        $kebabsRepository = new KebabsRepository();
        return $kebabsRepository->findAll($alias);
    }
}

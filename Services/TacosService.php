<?php

namespace App\Services;

use App\Repository\TacosRepository;
use App\Services\CloudinaryService;
use App\Models\TacosModel;

class TacosService
{
    private $tacosRepository;

    public function __construct()
    {
        $this->tacosRepository = new TacosRepository();
    }

    public function addTacos(array $data): bool
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

        $tacosModel = new TacosModel();
        $tacosModel->hydrate($data);

        $alias = 'Tacos';
        $tacosRepository = new tacosRepository();
        return $tacosRepository->create($alias, $data);
    }

    public function updateTacos(string $id, array $data): bool
    {
        $cloudinaryService = new CloudinaryService();

        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $existingTacos = $this->getTacosById($id);

            if ($existingTacos && !empty($existingTacos['img'])) {
                $publicId = pathinfo($existingTacos['img'], PATHINFO_FILENAME);
                $cloudinaryService->deleteFile($publicId);
            }


            $imgPath = $cloudinaryService->validateAndUploadImage($_FILES['img']);
            if (!$imgPath) {
                return false;
            }

            $data['img'] = $imgPath;
        } else {
            $existingTacos = $this->getTacosById($id);
            $data['img'] = $existingTacos['img'] ?? null;
        }


        $data = [
            'nom' => $data['nom'],
            'solo' => $data['solo'],
            'menu' => $data['menu'],
            'description' => $data['description'],
            'img' => $data['img'],
        ];

        $tacosModel = new TacosModel();
        $tacosModel->hydrate($data);
        $alias = 'Tacos';

        $tacosRepository = new TacosRepository();
        return $tacosRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deleteTacos(string $id): bool
    {
        $alias = 'Tacos';
        $tacos = $this->tacosRepository->find($alias, $id);

        if (!$tacos) {
            return false;
        }
        if (!empty($tacos['img'])) {
            $cloudinaryService = new CloudinaryService();
            $publicId = pathinfo($tacos['img'], PATHINFO_FILENAME);
            if (!$cloudinaryService->deleteFile($publicId)) {
                error_log("Échec de la suppression de l'image sur Cloudinary pour le tacos ID : $id");
            }
        }
        $tacosRepository = new TacosRepository();
        return $tacosRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getTacosById(string $id): ?array
    {
        $alias = 'Tacos';
        $tacosRepository = new TacosRepository();
        return $tacosRepository->find($alias, $id);
    }

    public function getAllTacos(): array
    {
        $alias = 'Tacos';
        $tacosRepository = new TacosRepository();
        return $tacosRepository->findAll($alias);
    }

}
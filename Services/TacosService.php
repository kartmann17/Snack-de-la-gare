<?php

namespace App\Services;

use App\Repository\TacosRepository;
use App\Services\CloudinaryService;

class TacosService
{
    private $tacosRepository;
    private $cloudinaryService;

    public function __construct()
    {
        $this->tacosRepository = new TacosRepository();
        $this->cloudinaryService = new CloudinaryService();
    }

    public function addTacos(array $data, ?string $imgPath): bool
    {
        $alias = 'Tacos';
        $data['img'] = $imgPath; 
        return $this->tacosRepository->create($alias, $data);
    }

    public function updateTacos(string $id, array $data, ?string $imgPath): bool
    {
        $alias = 'Tacos';
        if ($imgPath) {
            $data['img'] = $imgPath;
        }
        return $this->tacosRepository->update(
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
        $publicId = pathinfo($tacos['img'], PATHINFO_FILENAME);
        $this->cloudinaryService->deleteFile($publicId);
    }

    // Supprimer le document dans la base
    return $this->tacosRepository->delete($alias, ['_id' => new \MongoDB\BSON\ObjectId($id)]) > 0;
}

    public function getTacosById(string $id): ?array
    {
        $alias = 'Tacos';
        return $this->tacosRepository->find($alias, $id);
    }

    public function getAllTacos(): array
    {
        $alias = 'Tacos';
        return $this->tacosRepository->findAll($alias);
    }

    public function getCloudinaryService(): CloudinaryService
    {
        return $this->cloudinaryService;
    }
}
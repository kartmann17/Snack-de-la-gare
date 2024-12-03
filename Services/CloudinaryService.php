<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
    private $cloudinary;

    /**
     * Initialise une instance de CloudinaryService.
     *
     * Configure la connexion à Cloudinary en utilisant les variables d'environnement.
     */
    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
                'api_secret' => $_ENV['CLOUDINARY_API_SECRET']
            ]
        ]);
    }

    /**
     * Téléverse un fichier sur Cloudinary.
     *
     * @param string $file Le fichier à téléverser.
     * @return string|false Retourne l'URL sécurisée de l'image téléversée, ou false en cas d'échec.
     */
    public function uploadFile($file)
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file, [
                "folder" => "Snack_de_la_gare/"
            ]);
            return $result['secure_url'];
        } catch (\Exception $e) {
            error_log("Erreur de téléversement sur Cloudinary : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un fichier de Cloudinary en utilisant son ID public.
     *
     * @param string $publicId L'ID public du fichier à supprimer.
     * @return bool Retourne true si le fichier a été supprimé, false sinon.
     */
    public function deleteFile($publicId)
    {
        try {
            $this->cloudinary->uploadApi()->destroy($publicId);
            return true;
        } catch (\Exception $e) {
            error_log("Erreur de suppression sur Cloudinary : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Extrait l'ID public d'une URL Cloudinary.
     *
     * @param string $url L'URL à analyser.
     * @return string L'ID public extrait.
     */
    public function getPublicIdFromUrl($url)
    {
        $path_parts = pathinfo($url);
        return substr($path_parts['basename'], 0, strpos($path_parts['basename'], '.'));
    }

    /**
     * Valide et téléverse une image sur Cloudinary.
     *
     * @param array $image Les détails de l'image téléchargée via un formulaire.
     * @return string|null Retourne l'URL sécurisée si l'image est valide et téléversée avec succès, null sinon.
     */
    public function validateAndUploadImage($image): ?string
    {
        if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (in_array($image['type'], $allowedTypes)) {
                $cloudinaryService = new CloudinaryService();
                return $cloudinaryService->uploadFile($image['tmp_name']);
            }
        }
        return null;
    }
}
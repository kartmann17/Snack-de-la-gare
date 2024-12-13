<?php

namespace App\Controllers;

use App\Repository\KebabsRepository;
use App\Services\CloudinaryService;

class DashKebabsController extends Controller

{

    public function index()
    {
        $title = "Ajout Kebab";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addKebab", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutKebab()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $imgPath = null;
            // Téléversement de l'image sur Cloudinary
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['img']['tmp_name'];

                // Appeler la méthode uploadFile pour téléverser l'image sur Cloudinary
                $cloudinaryService = new CloudinaryService();
                $imgPath = $cloudinaryService->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /Dashboard");
                    exit;
                }
            }

            // Hydratation des données
            $alias = 'kebabs';
            $data = [
                'nom' => $_POST['nom'] ??  null,
                'solo' => $_POST['solo'] ??  null,
                'menu' => $_POST['menu'] ?? null,
                'assiette' => $_POST['assiette'] ?? null,
                'description' => $_POST['description'] ?? null,
                'img' => $imgPath
            ];

            // Utilisation du repository
            $KebabsRepository = new KebabsRepository();
            $result = $KebabsRepository->create($alias, $data);

            if ($result) {
                $_SESSION['success_message'] = "Kebab ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du Kebab.";
            }
            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteKebab()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $KebabsRepository = new KebabsRepository();
                    $cloudinaryService = new CloudinaryService();
                    $alias = 'kebabs';

                    // Récupérer le document pour supprimer l'image associée
                    $kebab = $KebabsRepository->find($alias, $id);

                    if (!$kebab) {
                        $_SESSION['error_message'] = "Le kebab avec l'ID $id n'existe pas.";
                        header("Location: /DashKebabs/liste");
                        exit();
                    }

                    // Supprimer l'image sur Cloudinary
                    $publicId = pathinfo($kebab['img'], PATHINFO_FILENAME);
                    if (!$cloudinaryService->deleteFile($publicId)) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de l'image sur Cloudinary.";
                        header("Location: /DashKebabs/liste");
                        exit();
                    }

                    // Supprimer le document dans MongoDB
                    $deletedCount = $KebabsRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "Le kebab et son image ont été supprimés avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de la suppression du kebab.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID kebab invalide.";
            }

            // Redirection après tentative de suppression
            header("Location: /DashKebabs/liste");
            exit();
        }
    }

    public function updateKebab($id)
    {
        $KebabsRepository = new KebabsRepository();
        $cloudinaryService = new CloudinaryService();
        $alias = 'kebabs';

        // Récupérer le kebab à modifier
        $kebab = $KebabsRepository->find($alias, $id);

        if (!$kebab) {
            $_SESSION['error_message'] = "Le kebab avec l'ID $id n'existe pas.";
            header("Location: /DashKebabs/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de l'image
            $imgPath = $kebab['img']; // Conservation de l'image actuelle

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                // Supprimer l'ancienne image sur Cloudinary
                $publicId = pathinfo($kebab['img'], PATHINFO_FILENAME);
                if (!$cloudinaryService->deleteFile($publicId)) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de l'ancienne image sur Cloudinary.";
                    header("Location: /DashKebabs/liste");
                    exit;
                }

                // Téléverser la nouvelle image sur Cloudinary
                $tmpName = $_FILES['img']['tmp_name'];
                $newImgPath = $cloudinaryService->uploadFile($tmpName);

                if ($newImgPath) {
                    $imgPath = $newImgPath; // Met à jour le chemin de l'image
                } else {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de la nouvelle image.";
                    header("Location: /DashKebabs/liste");
                    exit;
                }
            }

            // Préparer les données pour la mise à jour
            $data = [
                'nom' => $_POST['nom'] ?? $kebab['nom'],
                'solo' => $_POST['solo'] ?? $kebab['solo'],
                'menu' => $_POST['menu'] ?? $kebab['menu'],
                'assiette' => $_POST['assiette'] ?? $kebab['assiette'],
                'description' => $_POST['description'] ?? $kebab['description'],
                'img' => $imgPath,
            ];

            try {
                // Mise à jour dans la base
                $updatedCount = $KebabsRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "Kebab modifié avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            }

            // Redirection après la modification
            header("Location: /DashKebabs/liste");
            exit;
        }

        $title = "Modifier Kebab";
        $this->render('Dashboard/updateKebab', compact('kebab', 'title'));
    }


    public function liste()
    {
        $title = "Liste Kebabs";

        $KebabsRepository = new KebabsRepository();
        $alias = 'kebabs';
        $kebabs = $KebabsRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeKebabs", compact('title', 'kebabs'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

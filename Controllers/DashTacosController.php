<?php

namespace App\Controllers;

use App\Repository\TacosRepository;
use App\Services\CloudinaryService;

class DashTacosController extends Controller
{


    public function index()
    {
        $title = "Ajout Tacos";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addtacos", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutTacos()
    {
        if (isset($_SESSION['id_User'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $imgPath = null;

                // Téléversement de l'image sur Cloudinary
                if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['img']['tmp_name'];

                    $cloudinaryService = new CloudinaryService();
                    $imgPath = $cloudinaryService->uploadFile($tmpName);

                    if (!$imgPath) {
                        $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                        header("Location: /Dashboard");
                        exit();
                    }
                }

                // Hydratation des données
                $alias = "Tacos";
                $data = [
                    'nom' => $_POST['nom'] ?? null,
                    'solo' => $_POST['solo'] ?? null,
                    'menu' => $_POST['menu'] ?? null,
                    'description' => $_POST['description'] ?? null,
                    'img' => $imgPath,
                ];

                // Utilisation du repository
                $TacosRepository = new TacosRepository();
                $result = $TacosRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "Tacos ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout du tacos.";
                }

                header("Location: /Dashboard");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function deleteTacos()
    {
        if (isset($_SESSION['id_User'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $TacosRepository = new TacosRepository();
                        $cloudinaryService = new CloudinaryService();
                        $alias = 'Tacos';

                        // Récupérer le tacos pour vérifier son existence et obtenir l'image associée
                        $tacos = $TacosRepository->find($alias, $id);
                        if (!$tacos) {
                            $_SESSION['error_message'] = "Le tacos avec l'ID $id n'existe pas.";
                            header("Location: /DashTacos/liste");
                            exit();
                        }

                        // Supprimer le document dans MongoDB
                        $deletedCount = $TacosRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            // Supprimer l'image associée sur Cloudinary
                            $publicId = pathinfo($tacos['img'], PATHINFO_FILENAME);
                            if (!$cloudinaryService->deleteFile($publicId)) {
                                $_SESSION['error_message'] = "Le tacos a été supprimé, mais l'image sur Cloudinary n'a pas pu être supprimée.";
                            } else {
                                $_SESSION['success_message'] = "Le tacos et son image ont été supprimés avec succès.";
                            }
                        } else {
                            $_SESSION['error_message'] = "Erreur lors de la suppression du tacos.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID tacos invalide.";
                }

                header("Location: /DashTacos/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }


    public function updateTacos($id)
    {
        if (isset($_SESSION['id_User'])) { 
            $TacosRepository = new TacosRepository();
            $cloudinaryService = new CloudinaryService();
            $alias = 'Tacos';

            // Récupérer le tacos à modifier
            $tacos = $TacosRepository->find($alias, $id);

            if (!$tacos) {
                $_SESSION['error_message'] = "Le tacos avec l'ID $id n'existe pas.";
                header("Location: /DashTacos/liste");
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $imgPath = $tacos['img'];

                // Gestion de l'image
                if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                    $publicId = pathinfo($tacos['img'], PATHINFO_FILENAME);
                    if (!$cloudinaryService->deleteFile($publicId)) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de l'ancienne image sur Cloudinary.";
                        header("Location: /DashTacos/liste");
                        exit();
                    }

                    $tmpName = $_FILES['img']['tmp_name'];
                    $newImgPath = $cloudinaryService->uploadFile($tmpName);

                    if ($newImgPath) {
                        $imgPath = $newImgPath;
                    } else {
                        $_SESSION['error_message'] = "Erreur lors du téléversement de la nouvelle image.";
                        header("Location: /DashTacos/liste");
                        exit();
                    }
                }

                // Préparer les données pour la mise à jour
                $data = [
                    'nom' => $_POST['nom'] ?? $tacos['nom'],
                    'solo' => $_POST['solo'] ?? $tacos['solo'],
                    'menu' => $_POST['menu'] ?? $tacos['menu'],
                    'description' => $_POST['description'] ?? $tacos['description'],
                    'img' => $imgPath,
                ];

                try {
                    $updatedCount = $TacosRepository->update(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)],
                        $data
                    );

                    if ($updatedCount > 0) {
                        $_SESSION['success_message'] = "Tacos modifié avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
                }

                header("Location: /DashTacos/liste");
                exit();
            }

            $title = "Modifier Tacos";
            $this->render('Dashboard/updateTacos', compact('tacos', 'title'));
        } else {
            http_response_code(404);
            exit();
        }
    }


public function liste()
{
    $title = "Liste Tacos";

    $TacosRepository = new TacosRepository();
    $alias = "Tacos";
    $tacos = $TacosRepository->findAll($alias);

    if (isset($_SESSION['id_User'])) {

        $this->render("Dashboard/listetacos", compact('title', 'tacos'));
    } else {

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

}
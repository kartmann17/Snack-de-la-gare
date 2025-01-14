<?php

namespace App\Controllers;

use App\Repository\BurgersRepository;
use App\Services\CloudinaryService;

class DashBurgersController extends Controller
{

    public function index()
    {
        $title = "Ajout Burgers";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addburgers", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBurger()
    {
        if (isset($_SESSION['id_User'])) { // Vérification si l'utilisateur est connecté
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
                        exit;
                    }
                }

                // Hydratation des données
                $alias = 'burgers';
                $data = [
                    'nom' => $_POST['nom'] ?? null,
                    'solo' => $_POST['solo'] ?? null,
                    'menu' => $_POST['menu'] ?? null,
                    'description' => $_POST['description'] ?? null,
                    'img' => $imgPath,
                ];

                $BurgersRepository = new BurgersRepository();
                $result = $BurgersRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "Burger ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout du burger.";
                }

                header("Location: /Dashboard");
                exit;
            }
        } else {
            http_response_code(404);
            exit;
        }
    }

    public function deleteBurger()
    {
        if (isset($_SESSION['id_User'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $BurgersRepository = new BurgersRepository();
                        $cloudinaryService = new CloudinaryService();
                        $alias = 'burgers';

                        $burger = $BurgersRepository->find($alias, $id);

                        if (!$burger) {
                            $_SESSION['error_message'] = "Le burger avec l'ID $id n'existe pas.";
                            header("Location: /DashBurgers/liste");
                            exit();
                        }

                        // Supprimer le burger dans la base de données
                        $deletedCount = $BurgersRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            // Supprimer l'image associée, si elle existe
                            if (!empty($burger['img'])) {
                                $publicId = pathinfo($burger['img'], PATHINFO_FILENAME);
                                if (!$cloudinaryService->deleteFile($publicId)) {
                                    $_SESSION['error_message'] = "Le burger a été supprimé, mais l'image sur Cloudinary n'a pas pu être supprimée.";
                                } else {
                                    $_SESSION['success_message'] = "Le burger et son image ont été supprimés avec succès.";
                                }
                            } else {
                                $_SESSION['success_message'] = "Le burger a été supprimé, mais aucune image associée n'a été trouvée.";
                            }
                        } else {
                            $_SESSION['error_message'] = "Erreur lors de la suppression du burger.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID burger invalide.";
                }

                header("Location: /DashBurgers/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function updateBurger($id)
{
    if (isset($_SESSION['id_User'])) {
        $BurgersRepository = new BurgersRepository();
        $cloudinaryService = new CloudinaryService();
        $alias = 'burgers';

        $burger = $BurgersRepository->find($alias, $id);

        if (!$burger) {
            $_SESSION['error_message'] = "Le burger avec l'ID $id n'existe pas.";
            header("Location: /DashBurgers/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = $burger['img'];

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $publicId = pathinfo($burger['img'], PATHINFO_FILENAME);
                if (!$cloudinaryService->deleteFile($publicId)) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de l'ancienne image sur Cloudinary.";
                    header("Location: /DashBurgers/liste");
                    exit;
                }

                $tmpName = $_FILES['img']['tmp_name'];
                $newImgPath = $cloudinaryService->uploadFile($tmpName);

                if ($newImgPath) {
                    $imgPath = $newImgPath;
                } else {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de la nouvelle image.";
                    header("Location: /DashBurgers/liste");
                    exit;
                }
            }

            $data = [
                'nom' => $_POST['nom'] ?? $burger['nom'],
                'solo' => $_POST['solo'] ?? $burger['solo'],
                'menu' => $_POST['menu'] ?? $burger['menu'],
                'description' => $_POST['description'] ?? $burger['description'],
                'img' => $imgPath,
            ];

            try {
                $updatedCount = $BurgersRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "Burger modifié avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            }

            header("Location: /DashBurgers/liste");
            exit;
        }

        $title = "Modifier Burger";
        $this->render('Dashboard/updateBurger', compact('burger', 'title'));
    } else {
        http_response_code(404);
        exit;
    }
}

    public function liste()
    {
        $title = "Liste Burgers";

        $BurgersRepository = new BurgersRepository();
        $alias = 'burgers';
        $burgers = $BurgersRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeBurgers", compact('title', 'burgers'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

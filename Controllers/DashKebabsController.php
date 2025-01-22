<?php

namespace App\Controllers;

use App\Services\KebabsService;

class DashKebabsController extends Controller
{
    private $kebabsService;

    public function __construct()
    {
        $this->kebabsService = new KebabsService();
    }

    public function index()
    {
        $title = "Ajout Kebab";
        if (isset($_SESSION['id_User'])) {
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
                $imgPath = $this->kebabsService->getCloudinaryService()->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /Dashboard");
                    exit;
                }
            }

            $data = [
                'nom' => $_POST['nom'] ?? null,
                'solo' => $_POST['solo'] ?? null,
                'menu' => $_POST['menu'] ?? null,
                'assiette' => $_POST['assiette'] ?? null,
                'description' => $_POST['description'] ?? null,
            ];

            $result = $this->kebabsService->addKebab($data, $imgPath);

            if ($result) {
                $_SESSION['success_message'] = "Kebab ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du kebab.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateKebab($id)
    {
        $kebab = $this->kebabsService->getKebabById($id);

        if (!$kebab) {
            $_SESSION['error_message'] = "Le kebab avec l'ID $id n'existe pas.";
            header("Location: /DashKebabs/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = $kebab['img'];

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $publicId = pathinfo($kebab['img'], PATHINFO_FILENAME);
                $this->kebabsService->getCloudinaryService()->deleteFile($publicId);

                $tmpName = $_FILES['img']['tmp_name'];
                $imgPath = $this->kebabsService->getCloudinaryService()->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /DashKebabs/liste");
                    exit;
                }
            }

            $data = [
                'nom' => $_POST['nom'] ?? $kebab['nom'],
                'solo' => $_POST['solo'] ?? $kebab['solo'],
                'menu' => $_POST['menu'] ?? $kebab['menu'],
                'assiette' => $_POST['assiette'] ?? $kebab['assiette'],
                'description' => $_POST['description'] ?? $kebab['description'],
            ];

            $result = $this->kebabsService->updateKebab($id, $data, $imgPath);

            if ($result) {
                $_SESSION['success_message'] = "Kebab modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashKebabs/liste");
            exit;
        }

        $title = "Modifier Kebab";
        $this->render('Dashboard/updateKebab', compact('kebab', 'title'));
    }

    public function deleteKebab()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->kebabsService->deleteKebab($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le kebab et son image ont été supprimés avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du kebab.";
                }
            } else {
                $_SESSION['error_message'] = "ID kebab invalide.";
            }

            header("Location: /DashKebabs/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Kebabs";
        $kebabs = $this->kebabsService->getAllKebabs();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeKebabs", compact('title', 'kebabs'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
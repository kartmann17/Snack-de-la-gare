<?php

namespace App\Controllers;

use App\Services\TacosService;

class DashTacosController extends Controller
{
    private $tacosService;

    public function __construct()
    {
        $this->tacosService = new TacosService();
    }

    public function index()
    {
        $title = "Ajout Tacos";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addtacos", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutTacos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = null;

            // Téléversement de l'image
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $imgPath = $this->tacosService->getCloudinaryService()->uploadFile($_FILES['img']['tmp_name']);
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
                'description' => $_POST['description'] ?? null,
            ];

            $result = $this->tacosService->addTacos($data, $imgPath);

            if ($result) {
                $_SESSION['success_message'] = "Tacos ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du tacos.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateTacos($id)
    {
        $tacos = $this->tacosService->getTacosById($id);

        if (!$tacos) {
            $_SESSION['error_message'] = "Le tacos avec l'ID $id n'existe pas.";
            header("Location: /DashTacos/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = $tacos['img'];

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $publicId = pathinfo($tacos['img'], PATHINFO_FILENAME);
                $this->tacosService->getCloudinaryService()->deleteFile($publicId);

                $imgPath = $this->tacosService->getCloudinaryService()->uploadFile($_FILES['img']['tmp_name']);
                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de la nouvelle image.";
                    header("Location: /DashTacos/liste");
                    exit;
                }
            }

            $data = [
                'nom' => $_POST['nom'] ?? $tacos['nom'],
                'solo' => $_POST['solo'] ?? $tacos['solo'],
                'menu' => $_POST['menu'] ?? $tacos['menu'],
                'description' => $_POST['description'] ?? $tacos['description'],
            ];

            $result = $this->tacosService->updateTacos($id, $data, $imgPath);

            if ($result) {
                $_SESSION['success_message'] = "Tacos modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashTacos/liste");
            exit;
        }

        $title = "Modifier Tacos";
        $this->render('Dashboard/updateTacos', compact('tacos', 'title'));
    }

    public function deleteTacos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->tacosService->deleteTacos($id);

                if ($result) {
                    $_SESSION['success_message'] = "Tacos supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du tacos.";
                }
            } else {
                $_SESSION['error_message'] = "ID tacos invalide.";
            }

            header("Location: /DashTacos/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Tacos";
        $tacos = $this->tacosService->getAllTacos();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listetacos", compact('title', 'tacos'));
        } else {
            http_response_code(404);
        }
    }
}
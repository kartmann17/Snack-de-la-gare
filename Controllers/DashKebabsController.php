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
            $data = $_POST;

            $kebabsService = new KebabsService();
            $result = $kebabsService->addKebab($data);

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $data['img'] = $_FILES['img'];
            }

            $kebabsService = new KebabsService();
            $result = $kebabsService->updateKebab($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Kebab modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashKebabs/liste");
            exit;
        }

        $title = "Modifier Kebab";
        $kebab = $this->kebabsService->getKebabById($id);
        $this->render('Dashboard/updateKebab', compact('kebab', 'title'));
    }

    public function deleteKebab()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $kebabsService = new KebabsService();
            $result = $kebabsService->deleteKebab($_POST['id']);

            $_SESSION['success_message'] = $result
                ? "Kebab et son image supprimés avec succès."
                : "Erreur lors de la suppression du kebab.";
        } else {
            $_SESSION['error_message'] = "ID kebab invalide.";
        }

        header("Location: /DashKebabs/liste");
        exit;
    }

    public function liste()
    {
        $title = "Liste Kebabs";
        $kebabsService = new KebabsService();
        $kebabs = $kebabsService->getAllKebabs();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeKebabs", compact('title', 'kebabs'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

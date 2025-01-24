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
            $data = $_POST;

            $tacosService = new TacosService();
            $result = $tacosService->addTacos($data);

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $data['img'] = $_FILES['img'];
            }

            $tacosService = new TacosService();
            $result = $tacosService->updateTacos($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Tacos modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashTacos/liste");
            exit;
        }

        $title = "Modifier Tacos";
        $tacos = $this->tacosService->getTacosById($id);
        $this->render('Dashboard/updateTacos', compact('tacos', 'title'));
    }

    public function deleteTacos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $tacosService = new TacosService();
            $result = $tacosService->deleteTacos($_POST['id']);

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

    public function liste()
    {
        $title = "Liste Tacos";
        $tacosService = new TacosService();
        $tacos = $tacosService->getAllTacos();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listetacos", compact('title', 'tacos'));
        } else {
            http_response_code(404);
        }
    }
}

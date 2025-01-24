<?php

namespace App\Controllers;

use App\Services\SoftService;

class DashSoftsController extends Controller
{
    private $softService;

    public function __construct()
    {
        $this->softService = new SoftService();
    }

    public function index()
    {
        $title = "Ajout Soft";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addSofts", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSoft()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $softService = new SoftService();
            $result = $softService->addSoft($data);

            if ($result) {
                $_SESSION['success_message'] = "La boisson a été ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la boisson.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateSoft($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data =  $_POST;

            $softService = new SoftService();
            $result = $softService->updateSoft($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Le soft a été modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSofts/liste");
            exit;
        }

        $title = "Modifier le soft";
        $soft = $this->softService->findSoftById($id);
        $this->render('Dashboard/updateSoft', compact('soft', 'title'));
    }

    public function deleteSoft()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'  && !empty($_POST['id'])) {
            $softService = new SoftService();
            $result = $softService->deleteSoft($_POST['id']);

                if ($result) {
                    $_SESSION['success_message'] = "Le soft a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du soft.";
                }

            header("Location: /DashSofts/liste");
            exit();
        }else {
            $_SESSION['error_message'] = "ID soft invalide.";
        }
    }

    public function liste()
    {
        $title = "Liste Softs";
        $softs = $this->softService->getAllSofts();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeSofts", compact('title', 'softs'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
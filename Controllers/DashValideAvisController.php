<?php

namespace App\Controllers;

use App\Services\ValideAvisService;

class DashValideAvisController extends Controller
{
    private $valideAvisService;

    public function __construct()
    {
        $this->valideAvisService = new ValideAvisService();
    }

    public function index()
    {
        if (isset($_SESSION['id_User'])) {
            $Avis = $this->valideAvisService->getNonValides();
            $this->render("Dashboard/valideAvis", compact("Avis"));
        } else {
            http_response_code(404);
        }
    }

    public function liste()
    {
        if (isset($_SESSION['id_User'])) {
            $Avis = $this->valideAvisService->getAllAvis();
            $this->render("Dashboard/listeavis", compact("Avis"));
        } else {
            http_response_code(404);
        }
    }

    public function deleteAvis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $id = $_POST['id'];

            $result = $this->valideAvisService->deleteAvis($id);

            if ($result) {
                $_SESSION['success_message'] = "L'avis a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de l'avis.";
            }

            header("Location: /DashValideAvis/liste");
            exit();
        }
    }

    public function validerAvis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $id = $_POST['id'];

            $result = $this->valideAvisService->validerAvis($id);

            if ($result) {
                $_SESSION['success_message'] = "Avis validé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la validation de l'avis.";
            }

            header("Location: /DashValideAvis/index");
            exit();
        }
    }
}
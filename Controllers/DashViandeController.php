<?php

namespace App\Controllers;

use App\Services\ViandeService;

class DashViandeController extends Controller
{
    private $viandeService;

    public function __construct()
    {
        $this->viandeService = new ViandeService();
    }

    public function index()
    {
        $title = "Ajout Viandes";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addViande", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutViande()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $viandeService = new ViandeService();
            $result = $viandeService->addViande($data);

            if ($result) {
                $_SESSION['success_message'] = "Viande ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la viande.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateViande($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $viandeService = new ViandeService();
            $result = $viandeService->updateViande($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Viande modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashViande/liste");
            exit;
        }

        $title = "Modifier viande";
        $viande = $this->viandeService->findViandeById($id);
        $this->render('Dashboard/updateViande', compact('viande', 'title'));
    }

    public function deleteViande()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $viandeService = new ViandeService();
            $result = $viandeService->deleteViande($_POST['id']);

            if ($result) {
                $_SESSION['success_message'] = "Viande supprimée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de la viande.";
            }

            header("Location: /DashViande/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Viandes";
        $viandes = $this->viandeService->getAllViandes();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeViande", compact('title', 'viandes'));
        } else {
            http_response_code(404);
        }
    }
}

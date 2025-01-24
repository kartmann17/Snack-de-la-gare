<?php

namespace App\Controllers;

use App\Services\VinsService;

class DashVinsController extends Controller
{
    private $vinsService;

    public function __construct()
    {
        $this->vinsService = new VinsService();
    }

    public function index()
    {
        $title = "Ajout Vins";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addVins", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutVins()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $vinsService = new VinsService();
            $result = $vinsService->addVins($data);

            $_SESSION['success_message'] = $result
                ? "Vins ajouté avec succès."
                : "Erreur lors de l'ajout du vins.";

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateVins($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $vinsService = new VinsService();
            $result = $vinsService->updateVins($id, $data);

            $_SESSION['success_message'] = $result
                ? "Vins modifié avec succès."
                : "Erreur lors de la modification du vins.";

            header("Location: /DashVins/liste");
            exit;
        }

        $title = "Modifier Vins";
        $vins = $this->vinsService->getVinsById($id);
        $this->render('Dashboard/updateVins', compact('vins', 'title'));
    }

    public function deleteVins()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $vinsService = new VinsService();
            $result = $vinsService->deleteVins($_POST['id']);

            $_SESSION['success_message'] = $result
                ? "Vins supprimé avec succès."
                : "Erreur lors de la suppression du vins.";
        } else {
            $_SESSION['error_message'] = "ID vin invalide.";
        }

        header("Location: /DashVins/liste");
        exit;
    }

    public function liste()
    {
        $title = "Liste Vins";
        $vins = $this->vinsService->getAllVins();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeVins", compact('title', 'vins'));
        } else {
            http_response_code(404);
        }
    }
}
<?php

namespace App\Controllers;

use App\Services\BieresService;

class DashBieresController extends Controller
{
    private $bieresService;

    public function __construct()
    {
        $this->bieresService = new BieresService();
    }

    public function index()
    {
        $title = "Ajout Bières";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addBieres", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBiere()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $bieresService = new BieresService();
            $result = $bieresService->addBiere($data);

            $_SESSION['success_message'] = $result
                ? "Bière ajoutée avec succès."
                : "Erreur lors de l'ajout de la bière.";

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateBiere($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $bieresService = new BieresService();
            $result = $bieresService->updateBiere($id, $data);

            $_SESSION['success_message'] = $result
                ? "Bière modifiée avec succès."
                : "Erreur lors de la modification de la bière.";

            header("Location: /DashBieres/liste");
            exit;
        }

        $title = "Modifier Bière";
        $biere = $this->bieresService->findBiereById($id);
        $this->render('Dashboard/updateBiere', compact('biere', 'title'));
    }

    public function deleteBiere()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $bieresService = new BieresService();
            $result = $bieresService->deleteBiere($_POST['id']);

            $_SESSION['success_message'] = $result
                ? "Bière supprimée avec succès."
                : "Erreur lors de la suppression de la bière.";
        } else {
            $_SESSION['error_message'] = "ID bière invalide.";
        }

        header("Location: /DashBieres/liste");
        exit;
    }

    public function liste()
    {
        $title = "Liste Bières";
        $bieresService = new BieresService();
        $bieres = $bieresService->getAllBieres();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeBieres", compact('title', 'bieres'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
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
        $title = "Ajout Bieres";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addBieres", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBiere()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null,
            ];

            $result = $this->bieresService->addBiere($data);

            if ($result) {
                $_SESSION['success_message'] = "La bière a été ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la bière.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateBiere($id)
    {
        $biere = $this->bieresService->findBiereById($id);

        if (!$biere) {
            $_SESSION['error_message'] = "La bière avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $biere['nom'],
                'prix' => $_POST['prix'] ?? $biere['prix'],
            ];

            $result = $this->bieresService->updateBiere($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "La bière a été modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashBieres/liste");
            exit;
        }

        $title = "Modifier la bière";
        $this->render('Dashboard/updateBiere', compact('biere', 'title'));
    }

    public function deleteBiere()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->bieresService->deleteBiere($id);

                if ($result) {
                    $_SESSION['success_message'] = "La bière a été supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune bière trouvée avec cet ID.";
                }
            } else {
                $_SESSION['error_message'] = "ID bière invalide.";
            }

            header("Location: /DashBieres/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Bières";
        $bieres = $this->bieresService->getAllBieres();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeBieres", compact('title', 'bieres'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
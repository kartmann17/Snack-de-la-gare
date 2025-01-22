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
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            $result = $this->viandeService->addViande($data);

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
        $viande = $this->viandeService->getViandeById($id);

        if (!$viande) {
            $_SESSION['error_message'] = "La viande avec l'ID $id n'existe pas.";
            header("Location: /DashViande/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $viande['nom'],
            ];

            $result = $this->viandeService->updateViande($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Viande modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashViande/liste");
            exit;
        }

        $title = "Modifier viande";
        $this->render('Dashboard/updateViande', compact('viande', 'title'));
    }

    public function deleteViande()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->viandeService->deleteViande($id);

                if ($result) {
                    $_SESSION['success_message'] = "Viande supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la viande.";
                }
            } else {
                $_SESSION['error_message'] = "ID viande invalide.";
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
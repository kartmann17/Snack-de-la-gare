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
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null,
            ];

            $result = $this->softService->addSoft($data);

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
        $soft = $this->softService->getSoftById($id);

        if (!$soft) {
            $_SESSION['error_message'] = "Le soft avec l'ID $id n'existe pas.";
            header("Location: /DashSofts/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $soft['nom'],
                'prix' => $_POST['prix'] ?? $soft['prix'],
            ];

            $result = $this->softService->updateSoft($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Le soft a été modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSofts/liste");
            exit;
        }

        $title = "Modifier le soft";
        $this->render('Dashboard/updateSoft', compact('soft', 'title'));
    }

    public function deleteSoft()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->softService->deleteSoft($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le soft a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du soft.";
                }
            } else {
                $_SESSION['error_message'] = "ID soft invalide.";
            }

            header("Location: /DashSofts/liste");
            exit();
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
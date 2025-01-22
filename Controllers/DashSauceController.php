<?php

namespace App\Controllers;

use App\Services\SaucesService;

class DashSauceController extends Controller
{
    private $saucesService;

    public function __construct()
    {
        $this->saucesService = new SaucesService();
    }

    public function index()
    {
        $title = "Ajout Sauce";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addSauce", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSauce()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            $result = $this->saucesService->addSauce($data);

            if ($result) {
                $_SESSION['success_message'] = "Sauce ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la sauce.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateSauce($id)
    {
        $sauce = $this->saucesService->getSauceById($id);

        if (!$sauce) {
            $_SESSION['error_message'] = "La sauce avec l'ID $id n'existe pas.";
            header("Location: /DashSauce/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $sauce['nom'],
            ];

            $result = $this->saucesService->updateSauce($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Sauce modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSauce/liste");
            exit;
        }

        $title = "Modifier Sauce";
        $this->render('Dashboard/updateSauce', compact('sauce', 'title'));
    }

    public function deleteSauce()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->saucesService->deleteSauce($id);

                if ($result) {
                    $_SESSION['success_message'] = "Sauce supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la sauce.";
                }
            } else {
                $_SESSION['error_message'] = "ID sauce invalide.";
            }

            header("Location: /DashSauce/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Sauces";
        $sauces = $this->saucesService->getAllSauces();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeSauces", compact('title', 'sauces'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
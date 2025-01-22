<?php

namespace App\Controllers;

use App\Services\SaladeService;

class DashSaladeController extends Controller
{
    private $saladeService;

    public function __construct()
    {
        $this->saladeService = new SaladeService();
    }

    public function index()
    {
        $title = "Ajout Salade";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addSalades", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSalade()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null,
                'description' => $_POST['description'] ?? null,
            ];

            $result = $this->saladeService->addSalade($data);

            if ($result) {
                $_SESSION['success_message'] = "Salade ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la salade.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateSalade($id)
    {
        $salade = $this->saladeService->getSaladeById($id);

        if (!$salade) {
            $_SESSION['error_message'] = "La salade avec l'ID $id n'existe pas.";
            header("Location: /DashSalade/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $salade['nom'],
                'prix' => $_POST['prix'] ?? $salade['prix'],
                'description' => $_POST['description'] ?? $salade['description'],
            ];

            $result = $this->saladeService->updateSalade($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Salade modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSalade/liste");
            exit;
        }

        $title = "Modifier Salade";
        $this->render('Dashboard/updateSalade', compact('salade', 'title'));
    }

    public function deleteSalade()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->saladeService->deleteSalade($id);

                if ($result) {
                    $_SESSION['success_message'] = "Salade supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la salade.";
                }
            } else {
                $_SESSION['error_message'] = "ID salade invalide.";
            }

            header("Location: /DashSalade/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Salades";
        $salades = $this->saladeService->getAllSalades();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeSalades", compact('title', 'salades'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
<?php

namespace App\Controllers;

use App\Services\SnackService;

class DashSnackController extends Controller
{
    private $snackService;

    public function __construct()
    {
        $this->snackService = new SnackService();
    }

    public function index()
    {
        $title = "Ajouter un snack";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addSnacks", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSnack()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null,
                'description' => $_POST['description'] ?? null,
            ];

            $result = $this->snackService->addSnack($data);

            if ($result) {
                $_SESSION['success_message'] = "Snack ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du snack.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateSnack($id)
    {
        $snack = $this->snackService->getSnackById($id);

        if (!$snack) {
            $_SESSION['error_message'] = "Le snack avec l'ID $id n'existe pas.";
            header("Location: /DashSnack/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $snack['nom'],
                'prix' => $_POST['prix'] ?? $snack['prix'],
                'description' => $_POST['description'] ?? $snack['description'],
            ];

            $result = $this->snackService->updateSnack($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Snack modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSnack/liste");
            exit;
        }

        $title = "Modifier snack";
        $this->render('Dashboard/updateSnack', compact('snack', 'title'));
    }

    public function deleteSnack()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->snackService->deleteSnack($id);

                if ($result) {
                    $_SESSION['success_message'] = "Snack supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du snack.";
                }
            } else {
                $_SESSION['error_message'] = "ID snack invalide.";
            }

            header("Location: /DashSnack/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Snack";
        $snacks = $this->snackService->getAllSnacks();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeSnacks", compact('title', 'snacks'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
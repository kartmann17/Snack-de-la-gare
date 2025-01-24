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
            $data = $_POST;

            $snackService = new SnackService();
            $result = $snackService->addSnack($data);

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $snackService = new SnackService();
            $result = $snackService->updateSnack($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Snack modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSnack/liste");
            exit;
        }

        $title = "Modifier snack";
        $snack = $this->snackService->getSnackById($id);
        $this->render('Dashboard/updateSnack', compact('snack', 'title'));
    }

    public function deleteSnack()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['id']) {
            $snackService = new SnackService();
            $result = $snackService->deleteSnack($_POST['id']);

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

    public function liste()
    {
        $title = "Liste Snack";
        $snackService = new SnackService();
        $snacks = $snackService->getAllSnacks();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeSnacks", compact('title', 'snacks'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
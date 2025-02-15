<?php

namespace App\Controllers;

use App\Services\SupplementService;

class DashSupplementsController extends Controller
{
    private $supplementService;

    public function __construct()
    {
        $this->supplementService = new SupplementService();
    }

    public function index()
    {
        $title = "Ajout supplements";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addSupplement", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSupplement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $supplementService = new SupplementService();
            $result = $supplementService->addSupplement($data);

            if ($result) {
                $_SESSION['success_message'] = "Supplément ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du supplément.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateSupplement($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $supplementService = new SupplementService();
            $result = $supplementService->updateSupplement($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Supplément modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashSupplements/liste");
            exit;
        }

        $title = "Modifier Supplément";
        $supplement = $this->supplementService->getSupplementById($id);
        $this->render('Dashboard/updateSupplement', compact('supplement', 'title'));
    }

    public function deleteSupplement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['id']) {
            $supplementService = new SupplementService();
            $result = $supplementService->deleteSupplement($_POST['id']);

            if ($result) {
                $_SESSION['success_message'] = "Supplément supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression du supplément.";
            }
        } else {
            $_SESSION['error_message'] = "ID supplément invalide.";
        }

        header("Location: /DashSupplements/liste");
        exit();
    }

    public function liste()
    {
        $title = "Liste Suppléments";
        $supplementService = new SupplementService();
        $supplements = $supplementService->getAllSupplements();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeSupplements", compact('title', 'supplements'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

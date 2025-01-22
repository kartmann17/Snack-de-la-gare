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
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null,
            ];

            $result = $this->vinsService->addVin($data);

            if ($result) {
                $_SESSION['success_message'] = "Vin ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du vin.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateVins($id)
    {
        $vin = $this->vinsService->getVinById($id);

        if (!$vin) {
            $_SESSION['error_message'] = "Le vin avec l'ID $id n'existe pas.";
            header("Location: /DashVins/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $vin['nom'],
                'prix' => $_POST['prix'] ?? $vin['prix'],
            ];

            $result = $this->vinsService->updateVin($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Vin modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashVins/liste");
            exit;
        }

        $title = "Modifier le vin";
        $this->render('Dashboard/updateVins', compact('vin', 'title'));
    }

    public function deleteVins()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->vinsService->deleteVin($id);

                if ($result) {
                    $_SESSION['success_message'] = "Vin supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du vin.";
                }
            } else {
                $_SESSION['error_message'] = "ID vin invalide.";
            }

            header("Location: /DashVins/liste");
            exit();
        }
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
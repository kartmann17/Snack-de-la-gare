<?php

namespace App\Controllers;

use App\Services\HorairesService;

class DashHoraireController extends Controller
{
    private $horairesService;

    public function __construct()
    {
        $this->horairesService = new HorairesService();
    }

    public function index()
    {
        $title = "Ajout Horaire";

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addHoraire", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function addHoraire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_User'])) {
            $data = $_POST;

            $horairesService = new HorairesService();
            $result = $horairesService->addHoraire($data);

            if ($result) {
                $_SESSION['success_message'] = "L'horaire a été ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de l'horaire.";
            }

            header("Location: /Dashboard");
            exit;
        }

        $title = "Ajouter un Horaire";
        $this->render('Dashboard/addHoraire', ['title' => $title]);
    }

    public function updateHoraire($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $horairesService = new HorairesService();
            $result = $horairesService->updateHoraire($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "L'horaire a été mis à jour avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /Dashboard");
            exit;
        }

        $title = "Modifier un Horaire";
        $horaire = $this->horairesService->getHoraireById($id);
        $this->render('Dashboard/updateHoraires', compact('horaire', 'title'));
    }

    public function deleteHoraire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $horairesService = new HorairesService();
            $result = $horairesService->deleteHoraire($_POST['id']);

            if ($result) {
                $_SESSION['success_message'] = "L'horaire a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de l'horaire.";
            }
        } else {
            $_SESSION['error_message'] = "ID invalide.";
        }

        header("Location: /DashHoraire/liste");
        exit();
    }

    public function liste()
    {
        $title = "Liste Horaires";
        $horairesService = new HorairesService();
        $horaires = $horairesService->getAllHoraires();

        if (isset($_SESSION['id_User'])) {
            $this->render('Dashboard/listeHoraires', [
                'horaires' => $horaires,
                'title' => $title,
            ]);
        } else {
            http_response_code(404);
        }
    }
}

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
            $data = [
                'jour' => $_POST['jour'] ?? null,
                'ouverture_M' => $_POST['ouverture_M'] ?? null,
                'ouverture_S' => $_POST['ouverture_S'] ?? null,
            ];

            $result = $this->horairesService->addHoraire($data);

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
        $horaire = $this->horairesService->getHoraireById($id);

        if (!$horaire) {
            $_SESSION['error_message'] = "L'horaire avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'jour' => $_POST['jour'] ?? $horaire['jour'],
                'ouverture_M' => $_POST['ouverture_M'] ?? $horaire['ouverture_M'],
                'ouverture_S' => $_POST['ouverture_S'] ?? $horaire['ouverture_S'],
            ];

            $result = $this->horairesService->updateHoraire($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "L'horaire a été mis à jour avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /Dashboard");
            exit;
        }

        $title = "Modifier un Horaire";
        $this->render('Dashboard/updateHoraires', compact('horaire', 'title'));
    }

    public function deleteHoraire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->horairesService->deleteHoraire($id);

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
    }

    public function liste()
    {
        $title = "Liste Horaires";
        $horaires = $this->horairesService->getAllHoraires();

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
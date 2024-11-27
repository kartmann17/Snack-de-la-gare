<?php

namespace App\Controllers;

use App\Repository\HoraireRepository;

class DashHoraireController extends Controller
{
    private $HoraireRepository;

    public function __construct()
    {
        $this->HoraireRepository = new HoraireRepository();
    }

    public function liste()
    {
        $horaires = $this->HoraireRepository->getAllHoraires();

        if (isset($_SESSION['id_User'])) {
            $title = "Liste Horaires";
            $this->render('Dashboard/listeHoraires', [
                'horaires' => $horaires,
                'title' => $title
            ]);
        } else {
            http_response_code(404);
        }
    }

    public function addHoraire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_User'])) {
            $jour = $_POST['jour'] ?? null;
            $ouverture_M = $_POST['ouverture_M'] ?? null;
            $ouverture_S = $_POST['ouverture_S'] ?? null;

            $this->HoraireRepository->ajouterHoraire($jour, $ouverture_M, $ouverture_S);

            header("Location: /Dashboard");
            exit;
        }

        $title = "Ajouter un Horaire";
        $this->render('Dashboard/addHoraire', ['title' => $title]);
    }

    public function updateHoraire($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jour = $_POST['jour'] ?? null;
            $ouverture_M = $_POST['ouverture_M'] ?? null;
            $ouverture_S = $_POST['ouverture_S'] ?? null;

            $result = $this->HoraireRepository->updateHoraire($id, $jour, $ouverture_M, $ouverture_S);
            if ($result) {
                header("Location: /Dashboard");
                exit;
            } else {
                echo "Erreur lors de la mise à jour de l'horaire.";
            }
        }

        // Pré-remplir le formulaire avec les données existantes
        $horaire = $this->HoraireRepository->getHoraireById($id);
        $title = "Modifier un Horaire";

        $this->render('Dashboard/updateHoraires', [
            'horaire' => $horaire,
            'title' => $title
        ]);
    }

    public function deleteHoraire($id)
    {
        if (isset($_SESSION['id_User'])) {
            $this->HoraireRepository->deleteHoraire($id);

            header("Location: /DashHoraire/liste");
            exit;
        } else {
            http_response_code(403);
            echo "Accès refusé.";
        }
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
}
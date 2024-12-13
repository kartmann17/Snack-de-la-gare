<?php

namespace App\Controllers;

use App\Repository\HoraireRepository;

class DashHoraireController extends Controller
{
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
            $alias = 'horaire';

            // Récupérer les données du formulaire
            $data = [
                'jour' => $_POST['jour'] ?? null,
                'ouverture_M' => $_POST['ouverture_M'] ?? null,
                'ouverture_S' => $_POST['ouverture_S'] ?? null
            ];

            try {
                $HoraireRepository = new HoraireRepository();

                // Ajouter un nouvel horaire
                $result = $HoraireRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "L'horaire a été ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout de l'horaire.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de l'ajout : " . $e->getMessage();
            }

            // Redirection après ajout
            header("Location: /Dashboard");
            exit;
        }

        $title = "Ajouter un Horaire";
        $this->render('Dashboard/addHoraire', ['title' => $title]);
    }


   public function updateHoraire($id)
{
    $HoraireRepository = new HoraireRepository();
    $alias = 'horaire';

    // Récupérer l'horaire à modifier
    $horaire = $HoraireRepository->find($alias, $id);

    if (!$horaire) {
        $_SESSION['error_message'] = "L'horaire avec l'ID $id n'existe pas.";
        header("Location: /Dashboard");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données envoyées
        $data = [
            'jour' => $_POST['jour'] ?? $horaire['jour'],
            'ouverture_M' => $_POST['ouverture_M'] ?? $horaire['ouverture_M'],
            'ouverture_S' => $_POST['ouverture_S'] ?? $horaire['ouverture_S']
        ];

        try {
            // Mise à jour dans la base
            $updatedCount = $HoraireRepository->update(
                $alias,
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                $data
            );

            if ($updatedCount > 0) {
                $_SESSION['success_message'] = "L'horaire a été mis à jour avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /Dashboard");
            exit;
        } catch (\Exception $e) {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }


    $title = "Modifier un Horaire";
    $this->render('Dashboard/updateHoraires', compact('horaire', 'title'));
}


public function deleteHoraire($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            $HoraireRepository = new HoraireRepository();
            $alias = 'horaire';

            // Vérifier l'existence de l'horaire avant suppression
            $horaire = $HoraireRepository->find($alias, $id);

            if (!$horaire) {
                $_SESSION['error_message'] = "L'horaire avec l'ID $id n'existe pas.";
                header("Location: /DashHoraire/liste");
                exit;
            }

            // Supprimer l'horaire dans MongoDB
            $deletedCount = $HoraireRepository->delete(
                $alias,
                ['_id' => new \MongoDB\BSON\ObjectId($id)]
            );

            if ($deletedCount > 0) {
                $_SESSION['success_message'] = "L'horaire a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de l'horaire.";
            }
        } catch (\Exception $e) {
            $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
        }

        // Redirection après suppression
        header("Location: /DashHoraire/liste");
        exit;
    }
}
}


public function liste()
{
    $title = "Liste Horaires";

    $HoraireRepository = new HoraireRepository();
    $alias = 'horaire';

    // Récupérer les horaires triés par ID
    $horaires = $HoraireRepository->findBy($alias, [], ['sort' => ['_id' => 1]]); // Tri par ID croissant

    if (isset($_SESSION['id_User'])) {
        $this->render('Dashboard/listeHoraires', [
            'horaires' => $horaires,
            'title' => $title
        ]);
    } else {
        http_response_code(404);
    }
}

}
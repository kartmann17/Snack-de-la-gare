<?php

namespace App\Controllers;

use App\Repository\BieresRepository;

class DashBieresController extends Controller
{

    public function index()
    {
        $title = "Ajout Bieres";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addBieres", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBiere()
{
    if (isset($_SESSION['id_User'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $alias = 'Nos_Bieres';
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null
            ];

            $BieresRepository = new BieresRepository();
            $result = $BieresRepository->create($alias, $data);

            if ($result) {
                $_SESSION['success_message'] = "La bière a été ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la bière.";
            }

            header("Location: /Dashboard");
            exit;
        }
    } else {
        http_response_code(404);
        exit;
    }
}


public function updateBiere($id)
{
    if (isset($_SESSION['id_User'])) {
        $BieresRepository = new BieresRepository();
        $alias = 'Nos_Bieres';

        // Trouver la bière existante par ID
        $biere = $BieresRepository->find($alias, $id);

        if (!$biere) {
            $_SESSION['error_message'] = "La bière avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Préparer les données pour la mise à jour
            $data = [
                'nom' => $_POST['nom'] ?? $biere['nom'],
                'prix' => $_POST['prix'] ?? $biere['prix'],
            ];

            try {
                // Mise à jour dans la base
                $updatedCount = $BieresRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "La bière a été modifiée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            }

            // Redirection après la mise à jour
            header("Location: /DashBieres/liste");
            exit;
        }


        $title = "Modifier la bière";
        $this->render('Dashboard/updateBiere', compact('biere', 'title'));
    } else {
        http_response_code(404);
        exit;
    }
}



public function deleteBiere()
{
    if (isset($_SESSION['id_User'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $BieresRepository = new BieresRepository();
                    $alias = 'Nos_Bieres';

                    // Suppression de la bière par ID
                    $deletedCount = $BieresRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "La bière a été supprimée avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Aucune bière n'a été trouvée avec cet ID.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID bière invalide.";
            }

            // Redirection vers le tableau de bord
            header("Location: /DashBieres/liste");
            exit();
        }
    } else {
        http_response_code(404); 
        exit();
    }
}


    public function liste()
    {
        $title = "Liste bieres";

        $BieresRepository = new BieresRepository();
        $alias = 'Nos_Bieres';
        $bieres = $BieresRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeBieres", compact('title', 'bieres'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

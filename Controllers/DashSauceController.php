<?php

namespace App\Controllers;

use App\Repository\SauceRepository;

class DashSauceController extends Controller
{

    public function index()
    {
        $title = "Ajout Sauce";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSauce", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSauce()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation des données
            $alias= "Sauces";
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            // Utilisation du repository
            $SauceRepository = new SauceRepository();
            $result = $SauceRepository->create($alias,$data);

            if ($result) {
                $_SESSION['success_message'] = "Sauce ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la sauce.";
            }
            header("Location: /Dashboard");
        }
    }

    public function deleteSauce()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $SauceRepository = new SauceRepository();
                    $alias = "Sauces";
                     // Suppression de la sauce par ID
                $deletedCount = $SauceRepository->delete(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)]
                );

                if ($deletedCount > 0) {
                    $_SESSION['success_message'] = "La sauce a été supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune sauce n'a été trouvée avec cet ID.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "ID bière invalide.";
        }

            // Redirection vers la dashboard
            header("Location: /DashSauce/liste");
            exit();
        }
    }

    public function updateSauce($id)
    {
        $SauceRepository = new SauceRepository();
        $alias = "Sauces";

        // Récupérer la viande à modifier
        $sauce =   $SauceRepository->find($alias, $id);

        if (!$sauce) {
            $_SESSION['error_message'] = "La sauce avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ?? $sauce['nom'],
            ];

            try {
                // Mise à jour dans la base
                $updatedCount = $SauceRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "La sauce a été modifiée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            }

            // Redirection après la modification
            header("Location: /DashSauce/liste");
            exit;
        }

        $title = "Modifier sauce";
        $this->render('Dashboard/updateSauce', [
            'sauce' => $sauce,
            'title' => $title
        ]);
    }
    public function liste()
    {
        $title = "Liste Sauces";

        $SauceRepository = new SauceRepository();
        $alias = "Sauces";
        $sauces = $SauceRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSauces", compact('title', 'sauces'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

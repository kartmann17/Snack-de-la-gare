<?php

namespace App\Controllers;

use App\Repository\ViandeRepository;

class DashViandeController extends Controller
{

    public function index()
    {
        $title = "Ajout Viandes";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addViande", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutViande()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation des données
            $alias = 'Viandes';
            $data = [
                'nom' => $_POST['nom'] ?? null
            ];

            // Utilisation du repository
            $ViandeRepository = new ViandeRepository();
            $result = $ViandeRepository->create($alias, $data);

            if ($result) {
                $_SESSION['success_message'] = "Viande ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la viande.";
            }
            header("Location: /Dashboard");
        }
    }

    public function deleteViande()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $ViandeRepository = new ViandeRepository();
                    $alias = "Viandes";

                    // Suppression de la bière par ID
                $deletedCount = $ViandeRepository->delete(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)]
                );

                if ($deletedCount > 0) {
                    $_SESSION['success_message'] = "La viande a été supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune viande n'a été trouvée avec cet ID.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "ID viande invalide.";
        }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updateViande($id)
    {
        $ViandeRepository = new ViandeRepository();
        $alias = "Viandes";
        // Récupérer la viande à modifier
        $viande =  $ViandeRepository->find($alias, $id);

        if (!$viande) {
            $_SESSION['error_message'] = "La viande avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ?? $viande['nom'],
            ];

            try {
                // Mise à jour dans la base
                $updatedCount = $ViandeRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "La viande a été mise à jour avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune viande n'a été trouvée avec cet ID.";
                }
            }catch (\Exception $e){
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : ". $e->getMessage();
            }

            // Redirection après la modification
            header("Location: /DashViande/liste");
            exit;
        }

        $title = "Modifier viande";
        $this->render('Dashboard/updateViande', [
            'viande' => $viande,
            'title' => $title
        ]);
    }

    public function liste()
    {
        $title = "Liste Viandes";

        $ViandeRepository = new ViandeRepository();
        $alias = "Viandes";
        $viandes =  $ViandeRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeViande", compact('title', 'viandes'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

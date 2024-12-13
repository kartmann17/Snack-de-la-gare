<?php

namespace App\Controllers;

use App\Repository\SupplementsRepository;

class DashSupplementsController extends Controller
{

    public function index()
    {
        $title = "Ajout supplements";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSupplement", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSupplement()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation des données
            $alias = "Supplements";
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            // Utilisation du repository
            $SupplementsRepository = new SupplementsRepository();
            $result = $SupplementsRepository->create($alias, $data);

            if ($result) {
                $_SESSION['success_message'] = "Supplement ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du supplement.";
            }
            header("Location: /Dashboard");
        }
    }

    public function deleteSupplement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $SupplementsRepository = new SupplementsRepository();
                    $alias = "Supplements";

                    $deletedCount = $SupplementsRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "Le supplement a été supprimé avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Aucune bière n'a été trouvée avec cet ID.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppresion : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID supplement invalide.";
            }


            // Redirection vers la dashboard
            header("Location: /DashSupplements/liste");
            exit();
        }
    }

    public function updateSupplement($id)
{
    $SupplementsRepository = new SupplementsRepository();
    $alias = 'Supplements';

    // Récupérer le supplément à modifier
    $supplement = $SupplementsRepository->find($alias, $id);

    if (!$supplement) {
        $_SESSION['error_message'] = "Le supplément avec l'ID $id n'existe pas.";
        header("Location: /DashSupplements/liste");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Préparer les données pour la mise à jour
        $data = [
            'nom' => $_POST['nom'] ?? $supplement['nom']
        ];

        try {
            // Mise à jour dans la base
            $updatedCount = $SupplementsRepository->update(
                $alias,
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                $data
            );

            if ($updatedCount > 0) {
                $_SESSION['success_message'] = "Supplément modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }
        } catch (\Exception $e) {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
        }

        // Redirection après la modification
        header("Location: /DashSupplements/liste");
        exit;
    }

    $title = "Modifier Supplément";
    $this->render('Dashboard/updateSupplement', compact('supplement', 'title'));
}


    public function liste()
    {
        $title = "Liste Viandes";

        $SupplementsRepository = new  SupplementsRepository();
        $alias = "Supplements";
        $supplements =  $SupplementsRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSupplements", compact('title', 'supplements'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

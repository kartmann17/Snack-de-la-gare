<?php

namespace App\Controllers;

use App\Repository\AvisRepository;

class DashValideAvisController extends Controller
{


    //affichage de la page valider avis avec uniquement les avis non validé
    public function index()
    {
        $AvisRepository = new AvisRepository();
        $Avis = $AvisRepository->findNonValides();
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/valideAvis", compact("Avis"));
        } else {
            http_response_code(404);
        }
    }

    // affichage de la liste des avis
    public function liste()
    {
        $title = "Liste Avis";

        $AvisRepository = new AvisRepository();
        $alias = "avis";
        $Avis = $AvisRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeavis",compact("Avis"));
        } else {
            http_response_code(404);
        }
    }

    //suppression des avis
    public function deleteAvis()
{
    if (isset($_SESSION['id_User'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $AvisRepository = new AvisRepository();
                    $alias = 'avis';

                    // Vérifier l'existence de l'avis avant suppression
                    $avis = $AvisRepository->find($alias, $id);
                    if (!$avis) {
                        $_SESSION['error_message'] = "L'avis avec l'ID $id n'existe pas.";
                        header("Location: /DashValideAvis/liste");
                        exit();
                    }

                    // Supprimer l'avis dans MongoDB
                    $deletedCount = $AvisRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "L'avis a été supprimé avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de l'avis.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID invalide.";
            }

            // Redirection après  suppression
            header("Location: /DashValideAvis/liste");
            exit();
        }
    } else {
        http_response_code(404);
        exit();
    }
}

    //validation des avis avec le bouton
    public function validerAvis()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $AvisRepository = new AvisRepository();
            $AvisRepository->DashValiderAvis($id);

            header("Location: /Dashboard");
            exit();
        } else {
            echo "Erreur : ID manquant.";
        }
    }
}

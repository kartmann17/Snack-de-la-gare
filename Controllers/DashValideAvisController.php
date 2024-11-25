<?php

namespace App\Controllers;

use App\Repository\AvisRepository;

class DashValideAvisController extends DashboardController
{

    // affichage de la liste des avis
    public function liste()
    {
        $AvisRepository = new AvisRepository();
        $Avis = $AvisRepository->findAll();
        if (isset($_SESSION['id_User'])) {
            $this->render(
                "Dashboard/listeAvis",
                compact("Avis")
            );
        } else {
            http_response_code(404);
        }
    }

    //suppression des avis
    public function deleteAvis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $AvisRepository = new AvisRepository();

                $result = $AvisRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "L'avis a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de l'avis.";
                }
            } else {
                $_SESSION['error_message'] = "ID invalide.";
            }

            // Redirection vers la liste des avis après supression
            header("Location: /DashValideAvis/liste");
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
}

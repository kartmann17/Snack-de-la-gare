<?php

namespace App\Controllers;

use App\Repository\AvisRepository;

class AvisController extends Controller
{

    public function index()
    {
        $this->render('Avis/index');
    }

    public function ajoutAvis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $etoiles = filter_var($_POST['etoiles'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $nom = htmlspecialchars(trim($_POST['nom']), ENT_QUOTES, 'UTF-8');
            $commentaire = htmlspecialchars(trim($_POST['commentaire']), ENT_QUOTES, 'UTF-8');

            // Vérification que tous les champs son remplis
            if (!empty($etoiles) && !empty($nom) && !empty($commentaire)) {
                $AvisRepository = new AvisRepository();
                $result = $AvisRepository->saveAvis($etoiles, $nom, $commentaire);

                if ($result) {

                    $_SESSION['success_message'] = "Votre avis a été soumis avec succès.";
                } else {
                    $_SESSION['error_message'] = "Une erreur s'est produite lors de l'enregistrement de votre avis. Veuillez réessayer.";
                }
            } else {
                $_SESSION['error_message'] = "Veuillez remplir tous les champs du formulaire.";
            }

            header("Location: /accueil");
            exit();
        }
    }
}


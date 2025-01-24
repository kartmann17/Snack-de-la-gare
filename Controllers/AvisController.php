<?php

namespace App\Controllers;

use App\Services\ValideAvisService;

class AvisController extends Controller
{

    public function index()
    {
        $this->render('Avis/index');
    }

    public function ajoutAvis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $valideAvisService = new ValideAvisService();
            $result = $valideAvisService->saveAvis($data);

            if ($result) {
                $_SESSION['success_message'] = "Votre avis a été soumis avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur s'est produite lors de l'enregistrement de votre avis. Veuillez vérifier les champs obligatoires.";
            }

            header("Location: /accueil");
            exit();
        }

        http_response_code(405);
        echo "Méthode non autorisée.";
        exit();
    }
}

<?php

namespace App\Controllers;

use App\Services\ConnexionService;

class ConnexionController extends Controller
{
    private $connexionService;

    public function __construct()
    {
        $this->connexionService = new ConnexionService();
    }

    // Page de connexion
    public function index()
    {
        $this->render('Connexion/index');
    }

    // Traitement de la connexion
    public function connexion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $user = $this->connexionService->authenticate($data);

            if ($user) {
                $this->connexionService->startSession($user);

                header("Location: /Dashboard");
                exit();
            } else {
                $_SESSION['error_message'] = "Identifiants incorrects.";
                header("Location: /Connexion");
                exit();
            }
        }

        // Méthode non autorisée
        http_response_code(405);
        echo "Méthode non autorisée.";
        exit();
    }

    // Déconnexion
    public function deconnexion()
    {
        $this->connexionService->logout();
        header("Location: /");
        exit();
    }
}
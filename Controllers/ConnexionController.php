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

    public function index()
    {

        $this->render('Connexion/index');
    }

    public function connexion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['pass'] ?? '');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "Email non valide";
                header("Location: /Connexion");
                exit();
            }

            // Authentification via le service
            $user = $this->connexionService->authenticate($email, $password);

            if ($user) {
                session_regenerate_id(true);

                // Stockage des informations utilisateur en session
                $_SESSION['id_User'] = $user->id;
                $_SESSION['nom'] = htmlspecialchars($user->nom, ENT_QUOTES, 'UTF-8');
                $_SESSION['prenom'] = htmlspecialchars($user->prenom, ENT_QUOTES, 'UTF-8');
                $_SESSION['role'] = htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8');
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header("Location: /Dashboard");
                exit();
            } else {
                $_SESSION['error_message'] = "Email ou mot de passe incorrect";
                header("Location: /Connexion");
                exit();
            }
        }
    }

    public function deconnexion()
    {
        // Déconnexion via le service
        $this->connexionService->logout();

        // Redirection vers l'accueil
        header("Location: /");
        exit();
    }
}
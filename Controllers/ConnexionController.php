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
            $data = $_POST;

            $connexionService = new ConnexionService();
            $user = $connexionService->authenticate($data);

            if ($user) {
                $this->connexionService->startSession($user);

                header("Location: /Dashboard");
                exit();
            } else {
                $_SESSION['error_message'] = "Email ou mot de passe incorrect.";
                header("Location: /Connexion");
                exit();
            }
        }

        http_response_code(405);
        echo "Méthode non autorisée.";
        exit();
    }

    public function deconnexion()
    {
        $connexionService = new ConnexionService();
        $connexionService->logout();

        header("Location: /");
        exit();
    }
}
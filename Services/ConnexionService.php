<?php

namespace App\Services;

use App\Repository\ConnexionRepository;

class ConnexionService
{
    private $connexionRepository;

    public function __construct()
    {
        $this->connexionRepository = new ConnexionRepository();
    }

    public function authenticate(string $email, string $password): ?object
    {
        // Récupérer l'utilisateur en fonction de l'email
        $user = $this->connexionRepository->search($email);

        // Vérification du mot de passe
        if ($user && password_verify($password, $user->pass)) {
            return $user;
        }

        return null; 
    }


    public function logout()
    {
        // Supprime toutes les données de session
        session_unset();
        session_destroy();
    }
}
<?php

namespace App\Test;

use App\Repository\ConnexionRepository;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ConnexionUserRepositoryTest extends TestCase
{
    public function testRecherche()
    {// Chargement variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $email = 'walter.morel@gmail.com';

        // Instancier le modèle ConnexionUserModel
        $ConnexionRepository = new ConnexionRepository();

        // Appele de la méthode recherche et capturer le résultat
        $result = $ConnexionRepository->search($email);

        // Vérification de l'email
        $this->assertSame($email, $result->email);

        // Vérifiecation des autres champs pour valider les informations de l'utilisateur
        $this->assertNotNull($result->id);
        $this->assertNotNull($result->nom);
        $this->assertNotNull($result->prenom);
        $this->assertNotNull($result->pass);
        $this->assertNotNull($result->role);
    }
}
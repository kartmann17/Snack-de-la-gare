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

    public function authenticate(array $data): ?array
    {
        $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = trim($data['pass'] ?? '');

        if (empty($email) || empty($password)) {
            return null;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        $user = $this->connexionRepository->search($email);

        if ($user && password_verify($password, $user->pass)) {
            return [
                'id' => $user->id,
                'nom' => htmlspecialchars($user->nom, ENT_QUOTES, 'UTF-8'),
                'prenom' => htmlspecialchars($user->prenom, ENT_QUOTES, 'UTF-8'),
                'role' => htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8'),
            ];
        }

        password_verify($password, '$2y$10$' . str_repeat('a', 53));

        return null;
    }

    // démarrage une session utilisateur
    public function startSession(array $user): void
    {
        session_regenerate_id(true);

        $_SESSION['id_User'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['last_activity'] = time();
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }
}
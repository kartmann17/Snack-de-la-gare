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
        if (empty($data['email']) || empty($data['pass'])) {
            return null;
        }

        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        $user = $this->connexionRepository->search($email);

        if ($user && password_verify($data['pass'], $user->pass)) {
            return [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'role' => $user->role,
            ];
        }

        return null;
    }


    public function startSession(array $user): void
    {
        session_regenerate_id(true);

        // Stocker les informations utilisateur dans la session
        $_SESSION['id_User'] = $user['id'];
        $_SESSION['nom'] = htmlspecialchars($user['nom'], ENT_QUOTES, 'UTF-8');
        $_SESSION['prenom'] = htmlspecialchars($user['prenom'], ENT_QUOTES, 'UTF-8');
        $_SESSION['role'] = htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8');
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }


    public function logout(): void
    {
        session_unset();
        session_destroy();
    }
}
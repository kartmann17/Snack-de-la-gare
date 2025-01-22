<?php

namespace App\Controllers;

use App\Services\UserService;

class DashUserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        if (isset($_SESSION['id_User'])) {
            $roles = $this->userService->getAllRoles();
            $this->render("Dashboard/addUser", compact('roles'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutUser()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'email' => $_POST['email'] ?? '',
            'pass' => password_hash($_POST['pass'] ?? '', PASSWORD_DEFAULT),
            'role' => $_POST['role'] ?? ''
        ];

        if (!empty($data['nom']) && !empty($data['prenom']) && !empty($data['email']) && !empty($data['role'])) {
            $result = $this->userService->addUser($data);

            if ($result) {
                $_SESSION['success_message'] = "Utilisateur ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de l'utilisateur.";
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont requis.";
        }

        header("Location: /DashUser/liste");
        exit;
    }
}

public function deleteUser()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

        if ($id) {
            $result = $this->userService->deleteUser((int)$id);

            if ($result) {
                $_SESSION['success_message'] = "L'utilisateur a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
            }
        } else {
            $_SESSION['error_message'] = "ID utilisateur invalide.";
        }

        // Redirection après suppression
        header("Location: /DashUser/liste");
        exit();
    }
}

    public function liste()
    {
        if (isset($_SESSION['id_User'])) {
            $users = $this->userService->getAllUsers();
            $this->render('Dashboard/listeUser', compact('users'));
        } else {
            http_response_code(404);
        }
    }
}
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
        $data = $_POST;

        $userService = new UserService();
        $result = $userService->addUser($data);

        if ($result) {
            $_SESSION['success_message'] = "Utilisateur ajouté avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de l'ajout de l'utilisateur. Vérifiez les champs obligatoires.";
        }

        header("Location: /DashUser/liste");
        exit;
    }

    http_response_code(405);
    echo "Méthode non autorisée.";
    exit;
}

public function deleteUser()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
        $userService = new UserService();
        $result = $userService->deleteUser($_POST['id']);

        if ($result) {
            $_SESSION['success_message'] = "L'utilisateur a été supprimé avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
        }
    } else {
        $_SESSION['error_message'] = "ID utilisateur invalide.";
    }

    header("Location: /DashUser/liste");
    exit();
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
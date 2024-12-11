<?php

namespace App\Controllers;

use App\Repository\RoleRepository;
use App\Repository\UserRepository;


class DashUserController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addUser");
        } else {
            http_response_code(404);
        }
    }

    //Ajout des users
    public function ajoutUser()
    {
        $userRepository = new UserRepository();
        $roleRepository = new RoleRepository();
        $users = $userRepository->findAll();
        $roles = $roleRepository->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $pass = $_POST['pass'] ?? '';
            $role = $_POST['role'] ?? '';

            if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($pass) && !empty($role)) {

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error_message'] = "L'email est invalide";
                    header("Location: /addUser");
                    exit;
                }

                // Hashage du mot de passe
                $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

                // Appel du modèle pour l'insertion
                $result = $userRepository->createUser($nom, $prenom, $email, $hashedPass, $role);

                if ($result) {
                    $_SESSION['success_message'] = "Utilisateur ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout de l'utilisateur.";
                }
            } else {
                $_SESSION['error_message'] = "Tous les champs sont requis.";
            }
            header("Location: /Dashboard");
            exit;
        }
    }


    //supression des utilisateurs
    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $userRepository = new UserRepository();

                $result = $userRepository->deleteById($id);

                if ($result) {
                    $_SESSION['success_message'] = "L'utilisateur a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
                }
            } else {
                $_SESSION['error_message'] = "ID utilisateur invalide.";
            }

            // Redirection vers le dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    //Liste des utilisateurs
    public function liste()
    {
        $userRepository = new UserRepository();
        $users =  $userRepository->selectAllRole();
        if (isset($_SESSION['id_User'])) {
            $this->render(
                'Dashboard/listeUser',
                [
                    'users' => $users
                ]
            );
        } else {
            http_response_code(404);
        }
    }
}

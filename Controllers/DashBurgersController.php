<?php

namespace App\Controllers;

use App\Services\BurgersService;


class DashBurgersController extends Controller
{
    private $burgersService;

    public function __construct()
    {
        $this->burgersService = new BurgersService();
    }

    public function index()
    {
        $title = "Ajout Burgers";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addburgers", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBurger()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $burgersService = new BurgersService();
            $result = $burgersService->addBurger($data);

            if ($result) {
                $_SESSION['success_message'] = "Burger ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du burger.";
            }
            header("Location: /Dashboard");
            exit;
        }
    }

    public function updateBurger($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Gestion de l'image
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $data['img'] = $_FILES['img'];
            }

            $burgersService = new BurgersService();
            $result = $burgersService->updateBurger($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Burger modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du burger.";
            }

            header("Location: /DashBurgers/liste");
            exit;
        }

        $title = "Modifier Burger";
        $burger = $this->burgersService->getBurgerById($id);
        $this->render('Dashboard/updateBurger', compact('burger', 'title'));
    }

    public function deleteBurger()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $burgersService = new BurgersService();
            $result = $burgersService->deleteBurger($_POST['id']);

            $_SESSION['success_message'] = $result
                ? "Burger et son image supprimés avec succès."
                : "Erreur lors de la suppression du burger.";
        } else {
            $_SESSION['error_message'] = "ID burger invalide.";
        }

        header("Location: /DashBurgers/liste");
        exit;
    }

    public function liste()
    {
        $title = "Liste Burgers";
        $burgersService = new BurgersService();
        $burgers = $burgersService->getAllBurgers();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeBurgers", compact('title', 'burgers'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

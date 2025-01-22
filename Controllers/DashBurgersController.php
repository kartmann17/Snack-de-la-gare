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
            $imgPath = null;

            // Téléversement de l'image sur Cloudinary
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['img']['tmp_name'];
                $imgPath = $this->burgersService->getCloudinaryService()->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /Dashboard");
                    exit;
                }
            }

            // Données du formulaire
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'solo' => $_POST['solo'] ?? null,
                'menu' => $_POST['menu'] ?? null,
                'description' => $_POST['description'] ?? null,
            ];

            $result = $this->burgersService->addBurger($data, $imgPath);

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
        $burger = $this->burgersService->getBurgerById($id);

        if (!$burger) {
            $_SESSION['error_message'] = "Le burger avec l'ID $id n'existe pas.";
            header("Location: /DashBurgers/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = $burger['img'];

            // Gestion de l'image
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $publicId = pathinfo($burger['img'], PATHINFO_FILENAME);
                $this->burgersService->getCloudinaryService()->deleteFile($publicId);

                $tmpName = $_FILES['img']['tmp_name'];
                $imgPath = $this->burgersService->getCloudinaryService()->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /DashBurgers/liste");
                    exit;
                }
            }

            $data = [
                'nom' => $_POST['nom'] ?? $burger['nom'],
                'solo' => $_POST['solo'] ?? $burger['solo'],
                'menu' => $_POST['menu'] ?? $burger['menu'],
                'description' => $_POST['description'] ?? $burger['description'],
            ];

            $result = $this->burgersService->updateBurger($id, $data, $imgPath);

            if ($result) {
                $_SESSION['success_message'] = "Burger modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashBurgers/liste");
            exit;
        }

        $title = "Modifier Burger";
        $this->render('Dashboard/updateBurger', compact('burger', 'title'));
    }

    public function deleteBurger()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

        if ($id) {
            try {
                // Appel du service pour supprimer le burger
                $result = $this->burgersService->deleteBurger($id);

                if ($result) {
                    $_SESSION['success_message'] = "Burger et son image supprimés avec succès.";
                } else {
                    $_SESSION['error_message'] = "Le burger avec l'ID $id n'a pas été trouvé.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "ID burger invalide.";
        }

        // Redirection vers la liste des burgers
        header("Location: /DashBurgers/liste");
        exit();
    }
}

    public function liste()
    {
        $title = "Liste Burgers";
        $burgers = $this->burgersService->getAllBurgers();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeBurgers", compact('title', 'burgers'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
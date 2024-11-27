<?php

namespace App\Controllers;

use App\Repository\BurgersRepository;


class DashBurgersController extends Controller
{

    public function index()
    {
        $title = "Ajout Burgers";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addburgers", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBurger()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $imgPath = null;
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/Asset/images/';
                $tmpName = $_FILES['img']['tmp_name'];
                $fileName = pathinfo($_FILES['img']['name'], PATHINFO_FILENAME);
                $fileExtension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $img = $uploadDir . $fileName . '.' . $fileExtension;

                if (move_uploaded_file($tmpName, $img)) {
                    $imgPath = $fileName . '.' . $fileExtension;
                }
            }

            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'solo' => $_POST['solo'] ?? null,
                'menu' => $_POST['menu'] ?? null,
                'description' => $_POST['description'] ?? null,
                'img' => $imgPath,
            ];

            // Utilisation du repository
            $BurgersRepository = new BurgersRepository();
            $result = $BurgersRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Burger ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du burger.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteBurger()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $BurgersRepository = new BurgersRepository();

                $result = $BurgersRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le Burger a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du burger.";
                }
            } else {
                $_SESSION['error_message'] = "ID burger invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /DashBurgers/liste");
            exit();
        }
    }

    public function updateBurger($id)
    {
        $BurgersRepository = new BurgersRepository();

        // Récupérer le burger à modifier
        $burger = $BurgersRepository->find($id);

        if (!$burger) {
            $_SESSION['error_message'] = "Le burger avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de l'image
            $imgPath = $burger->img; // Conservation de l'image
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/Asset/images/';
                $tmpName = $_FILES['img']['tmp_name'];
                $fileName = pathinfo($_FILES['img']['name'], PATHINFO_FILENAME);
                $fileExtension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $img = $uploadDir . $fileName . '.' . $fileExtension;

                if (move_uploaded_file($tmpName, $img)) {
                    $imgPath = $fileName . '.' . $fileExtension;
                }
            }

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ?? $burger->nom,
                'solo' => $_POST['solo'] ?? $burger->solo,
                'menu' => $_POST['menu'] ?? $burger->menu,
                'description' => $_POST['description'] ?? $burger->description,
                'img' => $imgPath,
            ];

            // Mise à jour dans la base
            if ($BurgersRepository->update($id, $data)) {
                $_SESSION['success_message'] = "Burger modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du burger.";
            }

            // Redirection après la modification
            header("Location: /DashBurgers/liste");
            exit;
        }

        $title = "Modifier Burger";
        $this->render('Dashboard/updateBurger', [
            'burger' => $burger,
            'title' => $title
        ]);
    }

    public function liste()
    {
        $title = "Liste Burgers";

        $BurgersRepository = new BurgersRepository();

        $burgers = $BurgersRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeBurgers", compact('title', 'burgers'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

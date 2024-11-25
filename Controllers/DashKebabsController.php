<?php

namespace App\Controllers;

use App\Repository\KebabsRepository;

class DashKebabsController extends Controller

{

    public function index()
    {
        $title = "Ajout Kebab";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addKebab", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutKebab()
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
                } else {
                    $error = "Erreur lor du téléchargement de l'image";
                }
            }

            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ??  null,
                'solo' => $_POST['solo'] ??  null,
                'menu' => $_POST['menu'] ?? null,
                'assiette' => $_POST['assiette'] ?? null,
                'description' => $_POST['description'] ?? null,
                'img' => $imgPath
            ];

            // Utilisation du repository
            $KebabsRepository = new KebabsRepository();
            $result = $KebabsRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Kebab ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du Kebab.";
            }
            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteKebab()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $KebabsRepository = new KebabsRepository();

                $result = $KebabsRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le Kebab a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du kebab.";
                }
            } else {
                $_SESSION['error_message'] = "ID kebab invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /DashKebabs/liste");
            exit();
        }
    }

    public function updateKebab($id)
    {
        $KebabsRepository = new KebabsRepository();

        // Récupérer le kebab à modifier
        $kebab = $KebabsRepository->find($id);

        if (!$kebab) {
            $_SESSION['error_message'] = "Le kebab avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de l'image
            $imgPath = $kebab->img; // Conservation de l'image
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
                'nom' => $_POST['nom'] ??  null,
                'solo' => $_POST['solo'] ??  null,
                'menu' => $_POST['menu'] ?? null,
                'assiette' => $_POST['assiette'] ?? null,
                'description' => $_POST['description'] ?? null,
                'img' => $imgPath
            ];

            // Mise à jour dans la base
            if ($KebabsRepository->update($id, $data)) {
                $_SESSION['success_message'] = "Kebab modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du kebab.";
            }

            // Redirection après la modification
            header("Location: /DashKebabs/liste");
            exit;
        }

        $title = "Modifier Kebab";
        $this->render('Dashboard/updateKebab', [
            'kebab' => $kebab,
            'title' => $title
        ]);
    }


    public function liste()
    {
        $title = "Liste Kebabs";

        $KebabsRepository = new KebabsRepository();

        $kebabs = $KebabsRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeKebabs", compact('title', 'kebabs'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

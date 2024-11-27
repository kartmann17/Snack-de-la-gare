<?php

namespace App\Controllers;

use App\Repository\TacosRepository;

class DashTacosController extends Controller
{


    public function index()
    {
        $title = "Ajout Tacos";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addtacos", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutTacos()
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
        $TacosRepository = new TacosRepository();
        $result = $TacosRepository->create($data);

        if ($result) {
            $_SESSION['success_message'] = "Tacos ajouté avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de l'ajout du Tacos.";
        }

        header("Location: /Dashboard");
        exit;
    }
}

public function deleteTacos()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'] ?? null;

        if ($id) {
            $TacosRepository = new TacosRepository();

            $result = $TacosRepository->delete($id);

            if ($result) {
                $_SESSION['success_message'] = "Le Tacos a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression du Tacos.";
            }
        } else {
            $_SESSION['error_message'] = "ID Tacos invalide.";
        }

        // Redirection vers la dashboard
        header("Location: /DashTacos/liste");
        exit();
    }
}

public function updateTacos($id)
{
    $TacosRepository = new TacosRepository();

    // Récupérer le tacos à modifier
    $tacos = $TacosRepository->find($id);

    if (!$tacos) {
        $_SESSION['error_message'] = "Le tacos avec l'ID $id n'existe pas.";
        header("Location: /Dashboard");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Gestion de l'image
        $imgPath = $tacos->img; // Conservation de l'image
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
            'nom' => $_POST['nom'] ?? $tacos->nom,
            'solo' => $_POST['solo'] ?? $tacos->solo,
            'menu' => $_POST['menu'] ?? $tacos->menu,
            'description' => $_POST['description'] ?? $tacos->description,
            'img' => $imgPath,
        ];

        // Mise à jour dans la base
        if ($TacosRepository->update($id, $data)) {
            $_SESSION['success_message'] = "tacos modifié avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification du tacos.";
        }

        // Redirection après la modification
        header("Location: /DashTacos/liste");
        exit;
    }

    $title = "Modifier Tacos";
    $this->render('Dashboard/updateTacos', [
        'tacos' => $tacos,
        'title' => $title
    ]);
}

public function liste()
{
    $title = "Liste Tacos";

    $TacosRepository = new TacosRepository();

    $tacos = $TacosRepository->findAll();

    if (isset($_SESSION['id_User'])) {

        $this->render("Dashboard/listeTacos", compact('title', 'tacos'));
    } else {

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

}
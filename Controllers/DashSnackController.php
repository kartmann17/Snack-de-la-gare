<?php

namespace App\Controllers;

use App\Repository\SnackRepository;

class DashSnackController extends Controller
{

    public function index()
    {
        $title = "Ajouter un snack";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSnacks", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSnack()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'nom' => $_POST['nom'] ??  null,
                'prix' => $_POST['prix'] ??  null,
                'description' => $_POST['description'] ??  null
            ];

            // Utilisation du repository
            $SnackRepository = new SnackRepository();
            $result = $SnackRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Snack ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la snack.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }


    public function deleteSnack()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $SnackRepository = new SnackRepository();

                $result = $SnackRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le snack a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du snack.";
                }
            } else {
                $_SESSION['error_message'] = "ID snack invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }


    public function updateSnack($id)
    {
        $SnackRepository = new SnackRepository();

        // Récupérer la viande à modifier
        $snack =  $SnackRepository->find($id);

        if (!$snack) {
            $_SESSION['error_message'] = "Le snack avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ??  $snack->nom,
                'prix' => $_POST['prix'] ??  $snack->prix,
                'description' => $_POST['description'] ??  $snack->description

            ];

            // Mise à jour dans la base
            if ($SnackRepository->update($id, $data)) {
                $_SESSION['success_message'] = "Snack modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du snack.";
            }

            // Redirection après la modification
            header("Location: /DashSnack/liste");
            exit;
        }

        $title = "Modifier snack";
        $this->render('Dashboard/updateSnack', [
            'snack' => $snack,
            'title' => $title
        ]);
    }


    public function liste()
    {
        $title = "Liste Snack";

        $SnackRepository = new SnackRepository();

        $snacks = $SnackRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSnacks", compact('title', 'snacks'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

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
        if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $alias = "Nos_Snacks";
                $data = [
                    'nom' => $_POST['nom'] ?? null,
                    'prix' => $_POST['prix'] ?? null,
                    'description' => $_POST['description'] ?? null,
                ];

                // Utilisation du repository
                $SnackRepository = new SnackRepository();
                $result = $SnackRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "Snack ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout du snack.";
                }

                header("Location: /Dashboard");
                exit;
            }
        } else {
            http_response_code(404);
            exit;
        }
    }


    public function deleteSnack()
    {
        if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $SnackRepository = new SnackRepository();
                        $alias = "Nos_Snacks";

                        $deletedCount = $SnackRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            $_SESSION['success_message'] = "Le snack a été supprimé avec succès.";
                        } else {
                            $_SESSION['error_message'] = "Aucun snack n'a été trouvé avec cet ID.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID snack invalide.";
                }

                // Redirection vers la dashboard
                header("Location: /DashSnack/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }


    public function updateSnack($id)
    {
        if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
            $SnackRepository = new SnackRepository();
            $alias = "Nos_Snacks";

            // Récupérer le snack à modifier
            $snack = $SnackRepository->find($alias, $id);

            if (!$snack) {
                $_SESSION['error_message'] = "Le snack avec l'ID $id n'existe pas.";
                header("Location: /Dashboard");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Préparer les données pour la mise à jour
                $data = [
                    'nom' => $_POST['nom'] ?? $snack['nom'],
                    'prix' => $_POST['prix'] ?? $snack['prix'],
                    'description' => $_POST['description'] ?? $snack['description'],
                ];

                try {
                    // Mise à jour dans la base
                    $updatedCount = $SnackRepository->update(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)],
                        $data
                    );

                    if ($updatedCount > 0) {
                        $_SESSION['success_message'] = "Le snack a été modifié avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
                }

                // Redirection après la modification
                header("Location: /DashSnack/liste");
                exit;
            }

            $title = "Modifier snack";
            $this->render('Dashboard/updateSnack', compact('snack', 'title'));
        } else {
            http_response_code(404);
            exit();
        }
    }


    public function liste()
    {
        $title = "Liste Snack";

        $SnackRepository = new SnackRepository();
        $alias = "Nos_Snacks";
        $snacks = $SnackRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSnacks", compact('title', 'snacks'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

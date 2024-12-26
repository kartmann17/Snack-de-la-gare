<?php

namespace App\Controllers;

use App\Repository\SaladesRepository;

class DashSaladeController extends Controller
{

    public function index()
    {
        $title = "Ajout Salade";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSalades", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSalade()
    {
        if (isset($_SESSION['id_User'])) { 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $alias = "Nos_Salades";
                $data = [
                    'nom' => $_POST['nom'] ?? null,
                    'prix' => $_POST['prix'] ?? null,
                    'description' => $_POST['description'] ?? null
                ];

                // Utilisation du repository
                $SaladesRepository = new SaladesRepository();
                $result = $SaladesRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "Salade ajoutée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout de la salade.";
                }

                header("Location: /Dashboard");
                exit;
            }
        } else {
            http_response_code(404);
            exit;
        }
    }

    public function deleteSalade()
    {
        if (isset($_SESSION['id_User'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $SaladesRepository = new SaladesRepository();
                        $alias = "Nos_Salades";

                        $deletedCount = $SaladesRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            $_SESSION['success_message'] = "La salade a été supprimée avec succès.";
                        } else {
                            $_SESSION['error_message'] = "Aucune salade n'a été trouvée avec cet ID.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID salade invalide.";
                }

                // Redirection vers la dashboard
                header("Location: /DashSalade/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function updateSalade($id)
    {
        if (isset($_SESSION['id_User'])) {
            $SaladesRepository = new SaladesRepository();
            $alias = "Nos_Salades";

            // Récupérer la salade à modifier
            $salade = $SaladesRepository->find($alias, $id);

            if (!$salade) {
                $_SESSION['error_message'] = "La salade avec l'ID $id n'existe pas.";
                header("Location: /Dashboard");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Préparer la requête
                $data = [
                    'nom' => $_POST['nom'] ?? $salade['nom'],
                    'prix' => $_POST['prix'] ?? $salade['prix'],
                    'description' => $_POST['description'] ?? $salade['description']
                ];

                try {
                    // Mise à jour dans la base
                    $updatedCount = $SaladesRepository->update(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)],
                        $data
                    );

                    if ($updatedCount > 0) {
                        $_SESSION['success_message'] = "La salade a été modifiée avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
                }

                // Redirection après la modification
                header("Location: /DashSalade/liste");
                exit;
            }

            $title = "Modifier salade";
            $this->render('Dashboard/updateSalade', compact('salade', 'title'));
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Salades";

        $SaladesRepository = new SaladesRepository();
        $alias = 'Nos_Salades';
        $salades = $SaladesRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSalades", compact('title', 'salades'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

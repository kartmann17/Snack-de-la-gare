<?php

namespace App\Controllers;

use App\Repository\SupplementsRepository;

class DashSupplementsController extends Controller
{

    public function index()
    {
        $title = "Ajout supplements";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSupplement", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSupplement()
    {
        if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Hydratation des données
                $alias = "Supplements";
                $data = [
                    'nom' => $_POST['nom'] ?? null,
                ];

                // Utilisation du repository
                $SupplementsRepository = new SupplementsRepository();
                $result = $SupplementsRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "Supplément ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout du supplément.";
                }
                header("Location: /Dashboard");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function deleteSupplement()
    {
        if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $SupplementsRepository = new SupplementsRepository();
                        $alias = "Supplements";

                        $deletedCount = $SupplementsRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            $_SESSION['success_message'] = "Le supplément a été supprimé avec succès.";
                        } else {
                            $_SESSION['error_message'] = "Aucun supplément n'a été trouvé avec cet ID.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID supplément invalide.";
                }

                // Redirection vers la dashboard
                header("Location: /DashSupplements/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function deleteSupplement()
    {
        if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $SupplementsRepository = new SupplementsRepository();
                        $alias = "Supplements";

                        $deletedCount = $SupplementsRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            $_SESSION['success_message'] = "Le supplément a été supprimé avec succès.";
                        } else {
                            $_SESSION['error_message'] = "Aucun supplément n'a été trouvé avec cet ID.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID supplément invalide.";
                }

                // Redirection vers la dashboard
                header("Location: /DashSupplements/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }


    public function liste()
    {
        $title = "Liste Viandes";

        $SupplementsRepository = new  SupplementsRepository();
        $alias = "Supplements";
        $supplements =  $SupplementsRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSupplements", compact('title', 'supplements'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

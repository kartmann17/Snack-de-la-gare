<?php

namespace App\Controllers;

use App\Repository\VinsRepository;

class DashVinsController extends Controller
{

    public function index()
    {
        $title = "Ajout Vins";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addVins", compact('title'));
        } else {
            http_response_code(404);
        }
    }


    public function ajoutVins()
    {
        if (isset($_SESSION['id_User'])) { 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $alias = "Nos_Vins";
                $data = [
                    'nom' => $_POST['nom'] ?? null,
                    'prix' => $_POST['prix'] ?? null
                ];

                $VinsRepository = new VinsRepository();
                $result = $VinsRepository->create($alias, $data);

                if ($result) {
                    $_SESSION['success_message'] = "Le vin a été ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout du vin.";
                }

                header("Location: /Dashboard");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    public function deleteVins()
    {
        if (isset($_SESSION['id_User'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;

                if ($id) {
                    try {
                        $VinsRepository = new VinsRepository();
                        $alias = 'Nos_Vins';

                        // Vérifier l'existence du document avant suppression
                        $vin = $VinsRepository->find($alias, $id);
                        if (!$vin) {
                            $_SESSION['error_message'] = "Le vin avec l'ID $id n'existe pas.";
                            header("Location: /DashVins/liste");
                            exit();
                        }

                        // Supprimer le document dans MongoDB
                        $deletedCount = $VinsRepository->delete(
                            $alias,
                            ['_id' => new \MongoDB\BSON\ObjectId($id)]
                        );

                        if ($deletedCount > 0) {
                            $_SESSION['success_message'] = "Le vin a été supprimé avec succès.";
                        } else {
                            $_SESSION['error_message'] = "Erreur lors de la suppression du vin.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "ID vin invalide.";
                }

                header("Location: /DashVins/liste");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }


    public function updateVins($id)
{
    if (isset($_SESSION['id_User'])) {
        $VinsRepository = new VinsRepository();
        $alias = 'Nos_Vins';

        // Récupérer le vin à modifier
        $vins = $VinsRepository->find($alias, $id);

        if (!$vins) {
            $_SESSION['error_message'] = "Le vin avec l'ID $id n'existe pas.";
            header("Location: /DashVins/liste");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Préparer les données pour la mise à jour
            $data = [
                'nom' => $_POST['nom'] ?? $vins['nom'],
                'prix' => $_POST['prix'] ?? $vins['prix']
            ];

            try {
                // Mise à jour dans la base
                $updatedCount = $VinsRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "Le vin a été modifié avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            }

            header("Location: /DashVins/liste");
            exit();
        }

        $title = "Modifier le vin";
        $this->render('Dashboard/updateVins', compact('vins', 'title'));
    } else {
        http_response_code(404);
        exit();
    }
}

    public function liste()
    {
        $title = "Liste vins";

        $VinsRepository = new VinsRepository;
        $alias = "Nos_Vins";
        $vins =  $VinsRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeVins", compact('title', 'vins'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

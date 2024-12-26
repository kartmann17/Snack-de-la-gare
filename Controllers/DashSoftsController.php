<?php

namespace App\Controllers;

use App\Repository\SoftRepository;

class DashSoftsController extends Controller
{

    public function index()
    {
        $title = "Ajout Soft";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSofts", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSoft()
{
    if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alias = "Nos_Soft";
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null
            ];

            $SoftRepository = new SoftRepository();
            $result = $SoftRepository->create($alias, $data);

            if ($result) {
                $_SESSION['success_message'] = "La boisson a été ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la boisson.";
            }

            header("Location: /Dashboard");
            exit;
        }
    } else {
        http_response_code(404);
        exit();
    }
}

public function deleteSoft()
{
    if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $SoftRepository = new SoftRepository();
                    $alias = "Nos_Soft";

                    $deletedCount = $SoftRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "La boisson a été supprimée avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Aucune boisson n'a été trouvée avec cet ID.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID boisson invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /DashSofts/liste");
            exit();
        }
    } else {
        http_response_code(404);
        exit();
    }
}

public function updateSoft($id)
{
    if (isset($_SESSION['id_User'])) { // Vérifie si l'utilisateur est connecté
        $SoftRepository = new SoftRepository();
        $alias = "Nos_Soft";
        $soft = $SoftRepository->find($alias, $id);

        if (!$soft) {
            $_SESSION['error_message'] = "Le soft avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Préparer la requête
            $data = [
                'nom' => $_POST['nom'] ?? $soft['nom'],
                'prix' => $_POST['prix'] ?? $soft['prix']
            ];

            try {
                $updatedCount = $SoftRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );

                if ($updatedCount > 0) {
                    $_SESSION['success_message'] = "Le soft a été modifié avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la modification du soft.";
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            }

            // Redirection après la modification
            header("Location: /DashSofts/liste");
            exit();
        }

        $title = "Modifier le soft";
        $this->render('Dashboard/updateSoft', compact('soft', 'title'));
    } else {
        http_response_code(404);
        exit();
    }
}



    public function liste()
{
    $title = "Liste Softs";

    $SoftRepository = new SoftRepository;
    $alias = "Nos_Soft";
    $softs =  $SoftRepository->findAll($alias);

    if (isset($_SESSION['id_User'])) {

        $this->render("Dashboard/listeSofts", compact('title', 'softs'));
    } else {

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

}
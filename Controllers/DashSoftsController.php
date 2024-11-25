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

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
            'nom' =>$_POST['nom'] ??  null,
            'prix' =>$_POST['prix'] ??  null
            ];

            $SoftRepository = new SoftRepository;
            $result = $SoftRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "La boisson a été ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la boisson.";
            }
            header("Location: /Dashboard");
            exit;

        }
    }

    public function deleteSoft()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $SoftRepository = new SoftRepository;

                $result =  $SoftRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "La boisson a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la boisson.";
                }
            } else {
                $_SESSION['error_message'] = "ID boisson invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updateSoft($id)
    {
        $SoftRepository = new SoftRepository;

        $soft = $SoftRepository->find($id);

        if (!$soft) {
            $_SESSION['error_message'] = "le soft avec l'id $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //preparae la requete
            $data = [
                'nom' => $_POST['nom']?? $soft->nom,
                'prix' => $_POST['prix']?? $soft->prix
            ];

            //Mis a jour dans la base
            if ($SoftRepository->update($id, $data)) {
                $_SESSION['success_message'] = "le soft a été modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du soft.";
            }

             // Redirection après la modification
            header("Location: /DashSofts/liste");
            exit;

    }

    $title = "Modifier le soft";
    $this->render('Dashboard/updateSoft', [
        'soft' => $soft,
        'title' => $title
    ]);
}



    public function liste()
{
    $title = "Liste Softs";

    $SoftRepository = new SoftRepository;

    $softs =  $SoftRepository->findAll();

    if (isset($_SESSION['id_User'])) {

        $this->render("Dashboard/listeSofts", compact('title', 'softs'));
    } else {

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

}
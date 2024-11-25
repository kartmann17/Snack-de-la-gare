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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'nom' => $_POST['nom'] ??  null,
                'prix' => $_POST['prix'] ??  null
            ];

            $VinsRepository = new VinsRepository;
            $result = $VinsRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Le vin a été ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du vin.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteVins()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $VinsRepository = new VinsRepository;

                $result =  $VinsRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le Vins a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du vins.";
                }
            } else {
                $_SESSION['error_message'] = "ID vins invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }


    public function updateVins($id)
    {
        $VinsRepository = new VinsRepository;

        $vins = $VinsRepository->find($id);

        if (!$vins) {
            $_SESSION['error_message'] = "le vins avec l'id $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //preparae la requete
            $data = [
                'nom' => $_POST['nom'] ?? $vins->nom,
                'prix' => $_POST['prix'] ?? $vins->prix
            ];

            //Mis a jour dans la base
            if ($VinsRepository->update($id, $data)) {
                $_SESSION['success_message'] = "le vins a été modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du vins.";
            }

            // Redirection après la modification
            header("Location: /DashVins/liste");
            exit;
        }

        $title = "Modifier le vins";
        $this->render('Dashboard/updateVins', [
            'vins' => $vins,
            'title' => $title
        ]);
    }


    public function liste()
    {
        $title = "Liste vins";

        $VinsRepository = new VinsRepository;

        $vins =  $VinsRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeVins", compact('title', 'vins'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

<?php

namespace App\Controllers;

use App\Repository\BieresRepository;

class DashBieresController extends Controller
{

    public function index()
    {
        $title = "Ajout Bieres";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addBieres", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutBiere()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
            'nom' =>$_POST['nom'] ??  null,
            'prix' =>$_POST['prix'] ??  null
            ];

            $BieresRepository = new BieresRepository();
            $result = $BieresRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "La bière a été ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la bière.";
            }

            header("Location: /Dashboard");
            exit;

        }
    }
    

    public function updateBiere($id)
    {
        $BieresRepository = new BieresRepository();

        $biere = $BieresRepository->find($id);

        if (!$biere) {
            $_SESSION['error_message'] = "la biere avec l'id $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //preparae la requete
            $data = [
                'nom' => $_POST['nom']?? $biere->nom,
                'prix' => $_POST['prix']?? $biere->prix
            ];

            //Mis a jour dans la base
            if ($BieresRepository->update($id, $data)) {
                $_SESSION['success_message'] = "la biere a été modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification de la biere.";
            }

             // Redirection après la modification
            header("Location: /DashBieres/liste");
            exit;

    }

    $title = "Modifier la biere";
    $this->render('Dashboard/updateBiere', [
        'biere' => $biere,
        'title' => $title
    ]);
}


    public function deleteBiere()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $BieresRepository = new BieresRepository();

                $result =  $BieresRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "La bière a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la bière.";
                }
            } else {
                $_SESSION['error_message'] = "ID bière invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }


    public function liste()
{
    $title = "Liste bieres";

    $BieresRepository = new BieresRepository();

    $bieres = $BieresRepository->findAll();

    if (isset($_SESSION['id_User'])) {

        $this->render("Dashboard/listeBieres", compact('title', 'bieres'));
    } else {

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

}
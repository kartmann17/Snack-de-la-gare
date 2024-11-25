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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'nom' => $_POST['nom'] ??  null,
                'prix' => $_POST['prix'] ??  null,
                'description' => $_POST['description'] ??  null
            ];

            // Utilisation du repository
            $SaladesRepository = new SaladesRepository();
            $result = $SaladesRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Salade ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la salade.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteSalade()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $SaladesRepository = new SaladesRepository();

                $result =  $SaladesRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "La salade a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la salade.";
                }
            } else {
                $_SESSION['error_message'] = "ID salade invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updateSalade($id)
    {
        $SaladesRepository = new SaladesRepository();

        // Récupérer la viande à modifier
        $salade =  $SaladesRepository->find($id);

        if (!$salade) {
            $_SESSION['error_message'] = "La salade avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ??  $salade->nom,
                'prix' => $_POST['prix'] ??  $salade->prix,
                'description' => $_POST['description'] ??  $salade->desription

            ];

            // Mise à jour dans la base
            if ($SaladesRepository->update($id, $data)) {
                $_SESSION['success_message'] = "salade modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification de la salade.";
            }

            // Redirection après la modification
            header("Location: /DashSalade/liste");
            exit;
        }

        $title = "Modifier salade";
        $this->render('Dashboard/updateSalade', [
            'salade' => $salade,
            'title' => $title
        ]);
    }

    public function liste()
    {
        $title = "Liste Salades";

        $SaladesRepository = new SaladesRepository();

        $salades = $SaladesRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSalades", compact('title', 'salades'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

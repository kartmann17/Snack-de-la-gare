<?php

namespace App\Controllers;

use App\Repository\SauceRepository;

class DashSauceController extends Controller
{

    public function index()
    {
        $title = "Ajout Sauce";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addSauce", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutSauce()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            // Utilisation du repository
            $SauceRepository = new SauceRepository();
            $result = $SauceRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Sauce ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la sauce.";
            }
            header("Location: /Dashboard");
        }
    }

    public function deleteSauce()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $SauceRepository = new SauceRepository();

                $result =   $SauceRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "La Sauce a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la sauce.";
                }
            } else {
                $_SESSION['error_message'] = "ID sauce invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updateSauce($id)
    {
        $SauceRepository = new SauceRepository();

        // Récupérer la viande à modifier
        $sauce =   $SauceRepository->find($id);

        if (!$sauce) {
            $_SESSION['error_message'] = "La sauce avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ?? $sauce->nom,
            ];

            // Mise à jour dans la base
            if ($SauceRepository->update($id, $data)) {
                $_SESSION['success_message'] = "sauce modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification de la sauce.";
            }

            // Redirection après la modification
            header("Location: /DashSauce/liste");
            exit;
        }

        $title = "Modifier sauce";
        $this->render('Dashboard/updateSauce', [
            'sauce' => $sauce,
            'title' => $title
        ]);
    }
    public function liste()
    {
        $title = "Liste Sauces";

        $SauceRepository = new SauceRepository();

        $sauces = $SauceRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSauces", compact('title', 'sauces'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

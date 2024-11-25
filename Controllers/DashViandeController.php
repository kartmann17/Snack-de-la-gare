<?php

namespace App\Controllers;

use App\Repository\ViandeRepository;

class DashViandeController extends Controller
{

    public function index()
    {
        $title = "Ajout Viandes";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addViande", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutViande()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            // Utilisation du repository
            $ViandeRepository = new ViandeRepository();
            $result = $ViandeRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Viande ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la viande.";
            }
            header("Location: /Dashboard");
        }
    }

    public function deleteViande()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $ViandeRepository = new ViandeRepository();

                $result =  $ViandeRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "La viande a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la viande.";
                }
            } else {
                $_SESSION['error_message'] = "ID viande invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updateViande($id)
    {
        $ViandeRepository = new ViandeRepository();

        // Récupérer la viande à modifier
        $viande =  $ViandeRepository->find($id);

        if (!$viande) {
            $_SESSION['error_message'] = "La viande avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ?? $viande->nom,
            ];

            // Mise à jour dans la base
            if ($ViandeRepository->update($id, $data)) {
                $_SESSION['success_message'] = "viande modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification de la viande.";
            }

            // Redirection après la modification
            header("Location: /DashViande/liste");
            exit;
        }

        $title = "Modifier viande";
        $this->render('Dashboard/updateViande', [
            'viande' => $viande,
            'title' => $title
        ]);
    }

    public function liste()
    {
        $title = "Liste Viandes";

        $ViandeRepository = new ViandeRepository();

        $viandes =  $ViandeRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeViande", compact('title', 'viandes'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

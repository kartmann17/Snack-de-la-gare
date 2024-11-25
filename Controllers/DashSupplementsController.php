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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ?? null,
            ];

            // Utilisation du repository
            $SupplementsRepository = new SupplementsRepository();
            $result = $SupplementsRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Supplement ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du supplement.";
            }
            header("Location: /Dashboard");
        }
    }

    public function deleteSupplement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $SupplementsRepository = new SupplementsRepository();

                $result = $SupplementsRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "Le supplement a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du supplement";
                }
            } else {
                $_SESSION['error_message'] = "ID supplement invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updateSupplement($id)
    {
        $SupplementsRepository = new SupplementsRepository();

        // Récupérer la viande à modifier
        $Supplement =   $SupplementsRepository->find($id);

        if (!$Supplement) {
            $_SESSION['error_message'] = "Le supplement avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ?? $Supplement->nom,
            ];

            // Mise à jour dans la base
            if ($SupplementsRepository->update($id, $data)) {
                $_SESSION['success_message'] = "Supplements modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification du Supplement.";
            }

            // Redirection après la modification
            header("Location: /DashSupplement/liste");
            exit;
        }

        $title = "Modifier Supplements";
        $this->render('Dashboard/updateSupplement', [
            'Supplement' => $Supplement,
            'title' => $title
        ]);
    }

    public function liste()
    {
        $title = "Liste Viandes";

        $SupplementsRepository = new  SupplementsRepository();

        $supplements =  $SupplementsRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeSupplements", compact('title', 'supplements'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

<?php

namespace App\Controllers;

use App\Services\EnCeMomentsService;

class DashEnCeMomentController extends Controller
{
    private $enCeMomentsService;

    public function __construct()
    {
        $this->enCeMomentsService = new EnCeMomentsService();
    }

    public function index()
    {
        $title = "Ajout offre En Ce Moment pour la page d'accueil";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addEnCeMoment", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutEnCeMoment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Vérifie si une image a été téléversée
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $enCeMomentsService = new EnCeMomentsService();
                $result = $enCeMomentsService->addEnCeMoment($data);

                if ($result) {
                    $_SESSION['success_message'] = "Élément ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout de l'élément.";
                }
            } else {
                $_SESSION['error_message'] = "Aucune image n'a été téléversée ou une erreur est survenue.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteEnCeMoment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $enCeMomentsService = new EnCeMomentsService();
            $result = $enCeMomentsService->deleteEnCeMoment($_POST['id']);

                if ($result) {
                    $_SESSION['success_message'] = "Image et son enregistrement supprimés avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression ou image introuvable.";
                }
            } else {
                $_SESSION['error_message'] = "ID invalide.";
            }

            header("Location: /DashEnCeMoment/liste");
            exit();
    }

    public function liste()
    {
        $title = "Liste En Ce Moment";
        $enCeMomentsService = new EnCeMomentsService();
        $encemoments = $enCeMomentsService->getAllEnCeMoments();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeEnCeMoment", compact('title', 'encemoments'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
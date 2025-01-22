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
            $imgPath = null;

            // Téléversement de l'image sur Cloudinary
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['img']['tmp_name'];
                $imgPath = $this->enCeMomentsService->getCloudinaryService()->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /Dashboard");
                    exit;
                }
            }

            // Données du formulaire
            $data = [
                'img' => $imgPath,
            ];

            $result = $this->enCeMomentsService->addEnCeMoment($data, $imgPath);

            if ($result) {
                $_SESSION['success_message'] = "Image ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de l'image.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteEnCeMoment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->enCeMomentsService->deleteEnCeMoment($id);

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
    }

    public function liste()
    {
        $title = "Liste En Ce Moment";
        $encemoments = $this->enCeMomentsService->getAllEnCeMoments();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listeEnCeMoment", compact('title', 'encemoments'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
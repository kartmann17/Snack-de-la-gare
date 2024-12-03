<?php

namespace App\Controllers;

use App\Repository\EnCeMomentRepository;
use App\Services\CloudinaryService;

class DashEnCeMomentController extends Controller
{
    public function index()
    {
        $title = "Ajout offre en cemoments page d'accueil";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addEnCeMoment", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutEnCeMoment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $cloudinaryService = new CloudinaryService();

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {

                $imgPath = $cloudinaryService->validateAndUploadImage($_FILES['img']);

                if ($imgPath) {
                    // Hydratation des données
                    $data = [
                        'img' => $imgPath
                    ];

                    $EnCeMomentRepository = new EnCeMomentRepository();
                    $result = $EnCeMomentRepository->create($data);

                    if ($result) {
                        $_SESSION['success_message'] = "Image ajoutée avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de l'ajout de l'image.";
                    }
                } else {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image sur Cloudinary.";
                }
            } else {
                $_SESSION['error_message'] = "Aucune image valide n'a été téléchargée.";
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
                $EnCeMomentRepository = new EnCeMomentRepository();

                $result = $EnCeMomentRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "L'image a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de l'image.";
                }
            } else {
                $_SESSION['error_message'] = "ID image invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /DashEnCeMoment/liste");
            exit();
        }
    }
    public function liste()
    {
        $title = "Liste En ce moment";

        $EnCeMomentRepository = new EnCeMomentRepository();

        $encemoments = $EnCeMomentRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeEnCeMoment", compact('title', 'encemoments'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
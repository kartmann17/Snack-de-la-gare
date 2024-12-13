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
            $EnCeMomentRepository = new EnCeMomentRepository();
            $alias = 'En_ce_moments';

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                // Téléverser l'image sur Cloudinary
                $imgPath = $cloudinaryService->uploadFile($_FILES['img']['tmp_name']);

                if ($imgPath) {
                    // Hydratation des données
                    $data = [
                        'img' => $imgPath,
                    ];

                    // Insertion dans la base de données
                    try {
                        $result = $EnCeMomentRepository->create($alias, $data);

                        if ($result) {
                            $_SESSION['success_message'] = "Image ajoutée avec succès.";
                        } else {
                            $_SESSION['error_message'] = "Erreur lors de l'ajout de l'image.";
                        }
                    } catch (\Exception $e) {
                        $_SESSION['error_message'] = "Erreur lors de l'ajout : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image sur Cloudinary.";
                }
            } else {
                $_SESSION['error_message'] = "Aucune image valide n'a été téléchargée.";
            }

            // Redirection après tentative d'ajout
            header("Location: /Dashboard");
            exit;
        }
    }

    public function deleteEnCeMoment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                try {
                    $EnCeMomentRepository = new EnCeMomentRepository();
                    $cloudinaryService = new CloudinaryService();
                    $alias = 'En_ce_moments';

                    // Récupérer le document pour supprimer l'image associée
                    $imageRecord = $EnCeMomentRepository->find($alias, $id);

                    if (!$imageRecord) {
                        $_SESSION['error_message'] = "L'image avec l'ID $id n'existe pas.";
                        header("Location: /DashEnCeMoment/liste");
                        exit();
                    }

                    // Supprimer l'image sur Cloudinary
                    $publicId = pathinfo($imageRecord['img'], PATHINFO_FILENAME);
                    if (!$cloudinaryService->deleteFile($publicId)) {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de l'image sur Cloudinary.";
                        header("Location: /DashEnCeMoment/liste");
                        exit();
                    }

                    // Supprimer le document dans MongoDB
                    $deletedCount = $EnCeMomentRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "L'image et son enregistrement ont été supprimés avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de l'enregistrement de l'image.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID image invalide.";
            }

            // Redirection vers la liste
            header("Location: /DashEnCeMoment/liste");
            exit();
        }
    }
    
    public function liste()
    {
        $title = "Liste En ce moment";

        $EnCeMomentRepository = new EnCeMomentRepository();
        $alias = 'En_ce_moments';
        $encemoments = $EnCeMomentRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listeEnCeMoment", compact('title', 'encemoments'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

<?php

namespace App\Controllers;

use App\Services\ValideAvisService;

class AvisController extends Controller
{

    public function index()
    {
        $this->render('Avis/index');
    }

    public function ajoutAvis()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');

        $data = $_POST;

        $valideAvisService = new ValideAvisService();
        $result = $valideAvisService->saveAvis($data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Votre avis a été soumis avec succès.']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Une erreur s\'est produite lors de l\'enregistrement de votre avis.']);
        }
        exit();
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit();
}
}

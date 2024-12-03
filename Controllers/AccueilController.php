<?php

namespace App\Controllers;
use App\Repository\AvisRepository;
use App\Repository\EnCeMomentRepository;


class AccueilController extends Controller
{
    public function index()
    {
        // Titre de la page
        $title = "Snack De La Gare";

        // Récupérer les données de la table avis validé
        $AvisRepository = new AvisRepository();
        $Avis = $AvisRepository->findAll();

        $EnCeMomentRepository = new EnCeMomentRepository();
        $encemoments = $EnCeMomentRepository->findAll();

        // Passer les données à la vue via la méthode render
        $this->render("accueil/index", [
            'title' => $title,
            'Avis' => $Avis,
            'encemoments' => $encemoments
        ]);
    }
}
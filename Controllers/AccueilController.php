<?php

namespace App\Controllers;
use App\Repository\AvisRepository;


class AccueilController extends Controller
{
    public function index()
    {
        $title = "Snack De La Gare";
        $AvisRepository = new AvisRepository();
        $Avis = $AvisRepository->findAll();

        $this->render("accueil/index",  compact("Avis", "title"));
    }
}
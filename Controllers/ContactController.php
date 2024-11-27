<?php

namespace App\Controllers;

use App\Repository\HoraireRepository;
class ContactController extends Controller
{
    public function index()
    {
        $HoraireRepository = new HoraireRepository();
        $horaire = $HoraireRepository->getAllHoraires();
        $this->render("Contact/index", compact("horaire"));
    }


}
<?php

namespace App\Controllers;

use App\Repository\HoraireRepository;
class ContactController extends Controller
{
    public function index()
    {
        $HoraireRepository = new HoraireRepository();
        $horaires = $HoraireRepository->getAllHoraires();
        $this->render("Contact/index", compact("horaires"));
    }


}
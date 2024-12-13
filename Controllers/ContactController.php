<?php

namespace App\Controllers;

use App\Repository\HoraireRepository;
class ContactController extends Controller
{
    public function index()
    {
        $HoraireRepository = new HoraireRepository();
        $alias = 'horaire';
        $horaires = $HoraireRepository->findAll($alias);
        $this->render("Contact/index", compact("horaires"));
    }

}
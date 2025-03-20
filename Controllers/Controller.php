<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $file, array $donnees = [])
    {

        // on extrait le contenu de $donnees
        extract($donnees); //methodes extract qui permet d'extraire les données
        ob_start(); //ouverture tempon memoire
        require_once ROOT . "/Views/" . $file . ".php";
        $contenu = ob_get_clean(); //fermeture du tempon mémoire après injection dans la variable
        require_once ROOT . "/Views/default.php";
    }
}

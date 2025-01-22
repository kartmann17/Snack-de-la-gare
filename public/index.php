<?php

use App\Autoloader;
use App\Config\Main;


// Inclure l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';


// Définition d'une constante avec le chemin racine du projet
define('ROOT', dirname(__DIR__));

require_once ROOT . '/Autoloader.php';
Autoloader::register();

$app = new Main();

$app->start();
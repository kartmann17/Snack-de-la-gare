<?php

namespace App\Config;

use PDO;

class Connexiondb extends PDO
{
    private static $instance;


    protected function __construct()
    {
        //connexion a la BDD
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
        parent::__construct($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //le singleton = instance unique d'une classe
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
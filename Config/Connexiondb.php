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
    /**
     * getInstance
     *
     * Cette méthode implémente le pattern de conception Singleton. Elle assure qu'une seule et unique
     * instance de la classe Connexiondb existe pendant toute la durée de vie de l'application.
     *
     * @return self Retourne l'unique instance de la classe Connexiondb.
     */
    public static function getInstance(): self
    {
        // Vérifie si une instance de la classe existe déjà.
        if (self::$instance === null) {
            // Si aucune instance n'existe, on en crée une nouvelle.
            // 'new self()' instancie un nouvel objet de la classe courante (Connexiondb)
            self::$instance = new self();
        }
        // Si une instance existe déjà, ou qu'elle vient d'être créée, on la retourne.
        // Cela assure que toutes les parties de l'application qui appellent getInstance() obtiendront
        // la même instance de la connexion à la base de données.
        return self::$instance;
    }
}
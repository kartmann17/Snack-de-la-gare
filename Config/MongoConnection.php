<?php

namespace App\Config;

use MongoDB\Client;

class MongoConnection
{
    protected $client;
    private \MongoDB\Database $db;
    private static ?MongoConnection $instance = null;

    public function __construct()
    {
        $this->client = $this->connect();
        $this->db = $this->client->selectDatabase($_ENV['MONGODB_DB']);
    }

    /**
     * Manages the connection to MongoDB.
     *
     * @return Client Returns the MongoDB client instance.
     */
    protected function connect(): Client
    {
        try {
            // Connect to MongoDB Atlas via the URI
            return new Client($_ENV['MONGODB_URI']);
        } catch (\Exception $e) {
            // Lance une exception au lieu de terminer le script
            throw new \RuntimeException("Erreur de connexion à MongoDB : " . $e->getMessage());
        }
    }

     /**
     * Retourne l'instance unique de Mongo.
     * @return MongoConnection
     */
    public static function getInstance(): MongoConnection
    {
        if (self::$instance === null) {
            self::$instance = new MongoConnection();
        }
        return self::$instance;
    }

    /**
     * Retourne la base de données MongoDB.
     * @return \MongoDB\Database
     */
    public function getDatabase(): \MongoDB\Database
    {
        return $this->db;
    }

}
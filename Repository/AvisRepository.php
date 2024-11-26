<?php

namespace App\Repository;

class AvisRepository extends Repository
{
    public function __construct()
    {
        $this->table = 'avis';
    }

    public function afficheAvis()
    {
        // Requête SQL pour récupérer tous les avis
        $sql = "SELECT * FROM  {$this->table}";
        $result = $this->req($sql)->fetchAll();
        return $result;
    }

    public function saveAvis($etoiles, $nom, $commentaire)
    {
        // Préparation et exécution de la requête
        return $this->req(
            "INSERT INTO {$this->table} (etoiles, nom, commentaire) VALUES (:etoiles, :nom, :commentaire)",
             [
                'etoiles' => $etoiles,
                'nom' => $nom,
                'commentaire' => $commentaire
            ]
        );
    }

    public function DashValiderAvis($id)
    {
        return $this->req("UPDATE {$this->table} SET valide = 1 WHERE id = ?", [$id]);
    }


    // Récupérer tous les avis non validés
    public function findNonValides()
    {
        $sql = "SELECT * FROM {$this->table} WHERE valide = 0";
        return $this->req($sql);
    }

    public function valideAvis($valide)
    {
        $sql = "SELECT * FROM {$this->table} WHERE valide = ?"; //permet d'afficher les avis sur la page d'accueil
        return $this->req($sql, [$valide])->fetchAll();
    }
}
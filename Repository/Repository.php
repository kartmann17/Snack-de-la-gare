<?php

namespace App\Repository;

use App\Config\Connexiondb;
use PDO;

abstract class Repository
{
    //Table de la base de données
    protected $table;



    public function findAll()
    {
        $query = $this->req("SELECT * FROM  {$this->table}");
        return $query->fetchAll();
    }



    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];

        //on boucle pour eclater le tableau
        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }
        // on transforme le tableau champ en une chaine de caractères
        $liste_champs = implode(' AND ', $champs);
        // on exécute la requete
        return $this->req(' SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs, $valeurs)->fetchAll();
    }



    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $query = $this->req($sql, [$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }


    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return $this->req($sql, array_values($data));
    }



    public function update($id, array $data)
    {
        $columns = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$this->table} SET $columns WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;

        return $this->req($sql, $values)->rowCount() > 0;
    }

    public function delete(int $id)
    {
        return $this->req("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }


    protected function req(string $sql, array $params = [])
    {
        $db = Connexiondb::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }


}
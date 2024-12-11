<?php

namespace App\Repository;


class UserRepository extends Repository
{
    public function __construct()
    {
        $this->table = "User";
    }

    public function selectionRole($role)
    {
        return $this->req("SELECT id FROM Role WHERE role = :role", ['role' => $role])->fetch();
    }

    public function getRoles()
    {
        return $this->req('SELECT * FROM Role')->fetchAll();
    }

    public function selectAllRole()
    {
        $sql = "
        SELECT
            u.id,
            u.nom,
            u.prenom,
            u.email,
            u.pass,
            r.role AS role
        FROM
            {$this->table} u
         JOIN
            Role r ON u.id_role = r.id";
        return $this->req($sql)->fetchAll();
    }

    public function createUser($nom, $prenom, $email, $pass, $id_role)
    {
        return $this->req(
            "INSERT INTO " . $this->table . " (nom, prenom, email, pass, id_role)
            VALUES (:nom, :prenom, :email, :pass, :id_role)",
            [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'pass' => $pass,
                'id_role' => $id_role
            ]
        );
    }

    public function listeUser()
    {
        // Requête SQL pour récupérer tous les user
        $sql = "SELECT * FROM  {$this->table}";
        $result = $this->req($sql)->fetchAll();
        return $result;
    }

    //supression des utilisateurs
    public function deleteById($id)
    {
        return $this->delete($id);
    }
}
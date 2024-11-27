<?php

namespace App\Repository;

class ConnexionRepository extends Repository
{

    public function __construct()
    {
        $this->table = 'User';
    }

    public function search($email)
    {
        return $this->req(
            "SELECT u.id, u.nom, u.prenom, u.email, u.pass, r.role
            FROM User u
            LEFT JOIN Role r ON u.id_role = r.id
            WHERE u.email = :email",
            [
                'email' => $email
            ])->fetch();
    }
}
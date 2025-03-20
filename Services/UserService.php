<?php

namespace App\Services;

use App\Models\UserModel;
use App\Repository\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->selectAllRole();
    }

    public function addUser(array $data)
    {
        if (empty($data['nom']) || empty($data['prenom'])
         || empty($data['email']) || empty($data['role'])
        || empty($data['pass'])) {
            return false;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $data = [
            'nom' => trim($data['nom']),
            'prenom' => trim($data['prenom']),
            'email' => trim($data['email']),
            'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
            'id_role' => $data['role']
        ];

        $userModel = new UserModel();
        $userModel->hydrate($data);

        $userRepository = new UserRepository();
        $userRepository->create($data);
    }

public function deleteUser(int $id)
{
    $user = $this->userRepository->find($id);

    if (!$user) {
        return false;
    }

    $userRepository = new UserRepository();
    $userRepository->delete($id);


}

    public function getAllRoles(): array
    {
        return $this->userRepository->getRoles();
    }
}
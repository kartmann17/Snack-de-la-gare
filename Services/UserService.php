<?php

namespace App\Services;

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

    public function addUser(array $data): bool
{
    $data['id_role'] = $data['role'];
    unset($data['role']);

    $result = $this->userRepository->create($data);

    return $result->rowCount() > 0;
}

public function deleteUser(int $id): bool
{
    $result = $this->userRepository->delete($id);

    return $result->rowCount() > 0;
}

    public function getAllRoles(): array
    {
        return $this->userRepository->getRoles();
    }
}
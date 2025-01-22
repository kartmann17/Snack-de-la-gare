<?php

namespace App\Services;

use App\Repository\PizzaRepository;

class PizzaService
{
    private $pizzaRepository;

    public function __construct()
    {
        $this->pizzaRepository = new PizzaRepository();
    }

    public function addPizza(array $data): bool
    {
        $alias = 'Pizza';
        return $this->pizzaRepository->create($alias, $data);
    }

    public function updatePizza(string $id, array $data): bool
    {
        $alias = 'Pizza';
        return $this->pizzaRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deletePizza(string $id): bool
    {
        $alias = 'Pizza';
        return $this->pizzaRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getPizzaById(string $id): ?array
    {
        $alias = 'Pizza';
        return $this->pizzaRepository->find($alias, $id);
    }

    public function getAllPizzas(): array
    {
        $alias = 'Pizza';
        return $this->pizzaRepository->findAll($alias);
    }
}
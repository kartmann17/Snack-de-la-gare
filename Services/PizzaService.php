<?php

namespace App\Services;

use App\Repository\PizzaRepository;
use App\Models\PizzaModel;

class PizzaService
{
    private $pizzaRepository;

    public function __construct()
    {
        $this->pizzaRepository = new PizzaRepository();
    }

    public function addPizza(array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
            'description' => $data['description'],
        ];

        // Hydrate le modèle
        $pizzaModel = new PizzaModel();
        $pizzaModel->hydrate($data);

        $alias = 'Pizza';
        $pizzaRepository = new PizzaRepository();
        return $pizzaRepository->create($alias, $data);
    }

    public function updatePizza(string $id, array $data): bool
    {
        $data = [
            'nom' => $data['nom'],
            'prix' => $data['prix'],
            'description' => $data['description'],
        ];

        // Hydrate le modèle
        $pizzaModel = new PizzaModel();
        $pizzaModel->hydrate($data);
        $alias = 'Pizza';

        $pizzaRepository = new PizzaRepository();
        return $pizzaRepository->update(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            $data
        ) > 0;
    }

    public function deletePizza(string $id): bool
    {
        $alias = 'Pizza';
        $pizza = $this->pizzaRepository->find($alias, $id);

        if (!$pizza) {
            return false;
        }
        $pizzaRepository = new PizzaRepository();
        return $pizzaRepository->delete(
            $alias,
            ['_id' => new \MongoDB\BSON\ObjectId($id)]
        ) > 0;
    }

    public function getPizzaById(string $id): ?array
    {
        $alias = 'Pizza';
        $pizzaRepository = new PizzaRepository();
        return $pizzaRepository->find($alias, $id);
    }

    public function getAllPizzas(): array
    {
        $alias = 'Pizza';
        $pizzaRepository = new PizzaRepository();
        return $pizzaRepository->findAll($alias);
    }
}

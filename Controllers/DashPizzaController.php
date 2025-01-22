<?php

namespace App\Controllers;

use App\Services\PizzaService;

class DashPizzaController extends Controller
{
    private $pizzaService;

    public function __construct()
    {
        $this->pizzaService = new PizzaService();
    }

    public function index()
    {
        $title = "Ajout Pizza";
        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/addPizza", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutPizza()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'prix' => $_POST['prix'] ?? null,
                'description' => $_POST['description'] ?? null,
            ];

            $result = $this->pizzaService->addPizza($data);

            if ($result) {
                $_SESSION['success_message'] = "Pizza ajoutée avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la pizza.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function updatePizza($id)
    {
        $pizza = $this->pizzaService->getPizzaById($id);

        if (!$pizza) {
            $_SESSION['error_message'] = "La pizza avec l'ID $id n'existe pas.";
            header("Location: /DashPizza/liste");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? $pizza['nom'],
                'prix' => $_POST['prix'] ?? $pizza['prix'],
                'description' => $_POST['description'] ?? $pizza['description'],
            ];

            $result = $this->pizzaService->updatePizza($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Pizza modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashPizza/liste");
            exit;
        }

        $title = "Modifier la pizza";
        $this->render('Dashboard/updatePizza', compact('pizza', 'title'));
    }

    public function deletePizza()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->pizzaService->deletePizza($id);

                if ($result) {
                    $_SESSION['success_message'] = "Pizza supprimée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la pizza.";
                }
            } else {
                $_SESSION['error_message'] = "ID pizza invalide.";
            }

            header("Location: /DashPizza/liste");
            exit();
        }
    }

    public function liste()
    {
        $title = "Liste Pizza";
        $pizzas = $this->pizzaService->getAllPizzas();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listePizza", compact('title', 'pizzas'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
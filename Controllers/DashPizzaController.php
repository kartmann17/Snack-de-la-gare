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
            $data = $_POST;

            $pizzaService = new PizzaService();
            $result = $pizzaService->addPizza($data);

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $pizzaService = new PizzaService();
            $result = $pizzaService->updatePizza($id, $data);

            if ($result) {
                $_SESSION['success_message'] = "Pizza modifiée avec succès.";
            } else {
                $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
            }

            header("Location: /DashPizza/liste");
            exit;
        }

        $title = "Modifier la pizza";
        $pizza = $this->pizzaService->getPizzaById($id);
        $this->render('Dashboard/updatePizza', compact('pizza', 'title'));
    }

    public function deletePizza()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['id']) {
            $pizzaService = new PizzaService();
            $result = $pizzaService->deletePizza($_POST['id']);

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

    public function liste()
    {
        $title = "Liste Pizza";
        $pizzaService = new PizzaService();
        $pizzas = $pizzaService->getAllPizzas();

        if (isset($_SESSION['id_User'])) {
            $this->render("Dashboard/listePizza", compact('title', 'pizzas'));
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}
<?php

namespace App\Controllers;

use App\Repository\PizzaRepository;

class DashPizzaController extends Controller
{

    public function index()
    {
        $title = "Ajout Pizza";
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue
            $this->render("Dashboard/addPizza", compact('title'));
        } else {
            http_response_code(404);
        }
    }

    public function ajoutPizza()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'nom' => $_POST['nom'] ??  null,
                'prix' => $_POST['prix'] ??  null,
                'description' => $_POST['description'] ??  null
            ];

            // Utilisation du repository
            $PizzaRepository = new PizzaRepository();
            $result = $PizzaRepository->create($data);

            if ($result) {
                $_SESSION['success_message'] = "Pizza ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la pizza.";
            }

            header("Location: /Dashboard");
            exit;
        }
    }

    public function deletePizza()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $PizzaRepository = new PizzaRepository();

                $result =  $PizzaRepository->delete($id);

                if ($result) {
                    $_SESSION['success_message'] = "La pizza a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la pizza.";
                }
            } else {
                $_SESSION['error_message'] = "ID pizza invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updatePizza($id)
    {
        $PizzaRepository = new PizzaRepository();

        // Récupérer la viande à modifier
        $pizza =  $PizzaRepository->find($id);

        if (!$pizza) {
            $_SESSION['error_message'] = "La pizza avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ??  $pizza->nom,
                'prix' => $_POST['prix'] ??  $pizza->prix,
                'description' => $_POST['description'] ??  $pizza->desription

            ];

            // Mise à jour dans la base
            if ($PizzaRepository->update($id, $data)) {
                $_SESSION['success_message'] = "pizza modifié avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification de la pizza.";
            }

            // Redirection après la modification
            header("Location: /DashPizza/liste");
            exit;
        }

        $title = "Modifier la pizza";
        $this->render('Dashboard/updatePizza', [
            'pizza' => $pizza,
            'title' => $title
        ]);
    }

    public function liste()
    {
        $title = "Liste Pizza";

        $PizzaRepository = new PizzaRepository();

        $pizzas = $PizzaRepository->findAll();

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listePizza", compact('title', 'pizzas'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

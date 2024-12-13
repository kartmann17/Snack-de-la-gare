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

            $alias = "Pizza";
            $data = [
                'nom' => $_POST['nom'] ??  null,
                'prix' => $_POST['prix'] ??  null,
                'description' => $_POST['description'] ??  null
            ];

            // Utilisation du repository
            $PizzaRepository = new PizzaRepository();
            $result = $PizzaRepository->create($alias, $data);

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
                try {
                    $PizzaRepository = new PizzaRepository();
                    $alias = 'Pizza';

                    // Supprimer le document dans MongoDB
                    $deletedCount = $PizzaRepository->delete(
                        $alias,
                        ['_id' => new \MongoDB\BSON\ObjectId($id)]
                    );

                    if ($deletedCount > 0) {
                        $_SESSION['success_message'] = "La pizza a été supprimée avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de la pizza.";
                    }
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = "ID pizza invalide.";
            }

            // Redirection après tentative de suppression
            header("Location: /Dashboard");
            exit();
        }
    }

    public function updatePizza($id)
    {
        $PizzaRepository = new PizzaRepository();
        $alias = "Pizza";

        // Récupérer la viande à modifier
        $pizza =  $PizzaRepository->find($alias, $id);

        if (!$pizza) {
            $_SESSION['error_message'] = "La pizza avec l'ID $id n'existe pas.";
            header("Location: /Dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Préparer de la requete
            $data = [
                'nom' => $_POST['nom'] ??  $pizza['nom'],
                'prix' => $_POST['prix'] ??  $pizza['prix'],
                'description' => $_POST['description'] ??  $pizza['desription']
            ];

            try {
                $updateCount = $PizzaRepository->update(
                    $alias,
                    ['_id' => new \MongoDB\BSON\ObjectId($id)],
                    $data
                );
                if ($updateCount > 0) {
                    $_SESSION['success_message'] = "La pizza a été modifiée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Aucune modification n'a été apportée.";
                }
            } catch (\Exception $e) {
                $_SESSION['success_message'] = "Erreur lors de la mise a jour." . $e->getMessage();
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
        $alias = "Pizza";
        $pizzas = $PizzaRepository->findAll($alias);

        if (isset($_SESSION['id_User'])) {

            $this->render("Dashboard/listePizza", compact('title', 'pizzas'));
        } else {

            http_response_code(404);
            echo "Page non trouvée.";
        }
    }
}

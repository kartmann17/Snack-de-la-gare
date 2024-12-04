<?php

namespace App\Config;

use App\Controllers\AccueilController;

class Main
{
    public function start()
    {
        // Je démarre la session pour pouvoir gérer des données comme le token CSRF
        session_start();

        // Si le token CSRF n'existe pas encore dans la session, je le crée
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Génération d'un token sécurisé
        }

        // Je récupère l'URL demandée par l'utilisateur
        $uri = $_SERVER['REQUEST_URI'];

        // Si l'URL n'est pas vide, qu'elle n'est pas simplement "/" et qu'elle finit par un "/", je corrige
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1); // Je supprime le dernier "/"
            http_response_code(301); // Redirection permanente
            header('Location: ' . $uri); // Redirection vers l'URL corrigée
            exit(); // Je termine le script après la redirection
        }

        // Si la requête est de type POST, je vérifie le token CSRF et je nettoie les données envoyées
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = $_POST['csrf_token'] ?? ''; // Je récupère le token envoyé
            $this->chekCsrfToken($csrfToken); // Vérification du token
            $_POST = $this->sanitizeFormData($_POST); // Nettoyage des données POST
        }

        // Je traite les paramètres passés dans l'URL
        // Par exemple : /home/index -> ['home', 'index']
        $params = isset($_GET['p']) ? explode('/', filter_var($_GET['p'], FILTER_SANITIZE_URL)) : [];

        // Si un contrôleur est spécifié dans l'URL
        if (isset($params[0]) && $params[0] != '') {
            // Je construis le nom du contrôleur à partir du premier paramètre
            $controllerName = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // Je vérifie si la classe du contrôleur existe
            if (class_exists($controllerName)) {
                $controller = new $controllerName(); // Instanciation du contrôleur
            } else {
                // Si le contrôleur n'existe pas, je renvoie une erreur 404
                $this->error404("Contrôleur non trouvé : $controllerName");
                return;
            }

            // Je récupère la méthode demandée, ou "index" par défaut
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            // Je vérifie si la méthode existe dans le contrôleur
            if (method_exists($controller, $action)) {
                // J'appelle la méthode avec les paramètres restants
                call_user_func_array([$controller, $action], $params);
            } else {
                // Si la méthode n'existe pas, erreur 404
                $this->error404("Méthode non trouvée : $action");
                return;
            }
        } else {
            // Si aucun contrôleur n'est spécifié, j'utilise le contrôleur par défaut
            $controller = new AccueilController();
            $controller->index(); // J'appelle la méthode index par défaut
        }
    }

    // Vérifie le token CSRF pour s'assurer qu'il est valide
    public function chekCsrfToken($token)
    {
        // Si le token de la session ne correspond pas à celui envoyé, je renvoie une erreur
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            http_response_code(403); // Erreur 403 : accès interdit
            echo "CSRF Token invalide.";
            exit(); // Je termine l'exécution du script
        }
    }

    // Nettoie les données reçues pour éviter les failles XSS
    private function sanitizeFormData(array $data)
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            // Si la valeur est un tableau, je nettoie récursivement
            if (is_array($value)) {
                $sanitizedData[$key] = $this->sanitizeFormData($value);
            } else {
                // Si c'est une chaîne, je supprime les balises HTML/JS
                if (is_string($value)) {
                    $sanitizedData[$key] = strip_tags($value);
                } else {
                    // Sinon, je garde la valeur telle quelle
                    $sanitizedData[$key] = $value;
                }
            }
        }
        return $sanitizedData; // Je retourne les données nettoyées
    }

    // Affiche une erreur 404 avec une page personnalisée
    private function error404($message = "La page que vous recherchez n'existe pas.")
    {
        http_response_code(404); // Envoi du code HTTP 404
        require_once __DIR__ . '/../Views/404.php';
        exit($message); // Affiche le message d'erreur et termine le script
    }
}
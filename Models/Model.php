<?php

namespace App\Models;

class Model
{

    /**
     * Remplit automatiquement les propriétés de l'objet en appelant les setters correspondants.
     *
     * @param array $data Tableau associatif contenant les données à hydrater dans l'objet.
     * @return self Retourne l'objet lui-même après l'hydratation.
     */
    public function hydrate($data)
    {
        // Parcourt chaque élément du tableau $data
        foreach ($data as $key => $value) {
            // Construit le nom du setter correspondant à la clé.
            // Exemple : si $key = "nom", alors $method = "setNom"
            $method = 'set' . ucfirst($key);

            // Vérifie si le setter existe bien dans la classe avant de l'appeler.
            if (method_exists($this, $method)) {
                // Appelle dynamiquement la méthode setter avec la valeur correspondante.
                $this->$method($value);
            }
        }
        // Retourne l'objet lui-même pour permettre le chaînage des méthodes.
        return $this;
    }
}

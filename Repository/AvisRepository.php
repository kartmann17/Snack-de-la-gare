<?php

namespace App\Repository;

class AvisRepository extends MongoRepository
{
    public function table($data)
    {
       return $this->create('avis', $data);
    }

    public function afficheAvis()
    {
       $AvisRepository = new AvisRepository();
       $alias = "avis";
       $Avis = $AvisRepository->findAll($alias);
    }

    public function saveAvis($etoiles, $nom, $commentaire)
{
    $alias = 'avis'; // Nom de la collection MongoDB

    // Préparation des données à insérer
    $data = [
        'etoiles' => $etoiles,
        'nom' => $nom,
        'commentaire' => $commentaire,
        'valide' => 0
    ];

    // Utilisation de la méthode `create` pour insérer dans MongoDB
    return $this->create($alias, $data);
}

public function DashValiderAvis($id)
{
    $alias = 'avis';

    // Critère pour sélectionner l'avis à valider
    $criteria = ['_id' => new \MongoDB\BSON\ObjectId($id)];

    // Mise à jour pour définir `valide` à 1
    $update = ['valide' => 1];

    // Mise à jour dans MongoDB
    return $this->update($alias, $criteria, $update);
}


    // Récupérer tous les avis non validés
    public function findNonValides()
    {
        $alias = 'avis';

        // Récupérer tous les avis non validés
        return $this->findBy($alias, ['valide' => 0]);
    }

    public function valideAvis($valide)
{
    $alias = 'avis';

    // Récupérer les avis validés ou non validés en fonction de la valeur de `$valide`
    return $this->findBy($alias, ['valide' => (int)$valide]);
}
}
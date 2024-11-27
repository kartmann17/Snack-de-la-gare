<?php

namespace App\Repository;

use App\Config\MongoConnection;
use MongoDB\BSON\ObjectId;

class HoraireRepository extends MongoConnection
{
    private $collection;


    public function __construct()
    {
        parent::__construct();
        $this->collection = $this->getCollection('Snack', 'horaire');
    }

    public function getHoraireById($id)
    {
        $result = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        // Convertion en objet
        return is_array($result) ? (object) $result : $result;
    }

    public function getAllHoraires()
    {
        return $this->collection->find()->toArray();
    }

    public function ajouterHoraire($jour, $ouverture_M, $ouverture_S)
    {
        $horaire = [
            'jour' => $jour,
            'ouverture_M' => $ouverture_M,
            'ouverture_S' => $ouverture_S,
        ];
        $this->collection->insertOne($horaire)->getInsertedId();
    }

    public function deletehoraire($id)
    {
        $filter = ['_id' => new ObjectId($id)];
        $this->collection->deleteOne($filter);
    }

    public function updateHoraire($id, $jour, $ouverture_M, $ouverture_S)
    {
        $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
        $update = [
            '$set' => [
                'jour' => $jour,
                'ouverture_M' => $ouverture_M,
                'ouverture_S' => $ouverture_S
            ]
        ];
        $result = $this->collection->updateOne($filter, $update);
        return $result->getModifiedCount() > 0;
    }
}

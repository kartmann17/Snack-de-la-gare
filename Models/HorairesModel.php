<?php

namespace App\Models;

class HorairesModel extends Model
{
    protected $id;
    protected $jour;
    protected $ouverture_M;
    protected $ouverture_S;



    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of jour
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Set the value of jour
     *
     * @return  self
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get the value of ouverture_M
     */
    public function getOuverture_M()
    {
        return $this->ouverture_M;
    }

    /**
     * Set the value of ouverture_M
     *
     * @return  self
     */
    public function setOuverture_M($ouverture_M)
    {
        $this->ouverture_M = $ouverture_M;

        return $this;
    }

    /**
     * Get the value of ouverture_S
     */
    public function getOuverture_S()
    {
        return $this->ouverture_S;
    }

    /**
     * Set the value of ouverture_S
     *
     * @return  self
     */
    public function setOuverture_S($ouverture_S)
    {
        $this->ouverture_S = $ouverture_S;

        return $this;
    }
}
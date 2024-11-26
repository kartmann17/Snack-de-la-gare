<?php

namespace App\Models;


class AvisModel extends Model
{
    protected $id;
    protected $etoiles;
    protected $nom;
    protected $commentaire;
    protected $valide;



    /**
     * Get the value of etoiles
     */
    public function getEtoiles()
    {
        return $this->etoiles;
    }

    /**
     * Set the value of etoiles
     *
     * @return  self
     */
    public function setEtoiles($etoiles)
    {
        $this->etoiles = $etoiles;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of commentaire
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of commentaire
     *
     * @return  self
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get the value of valide
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set the value of valide
     *
     * @return  self
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }
}

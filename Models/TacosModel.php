<?php

namespace App\Models;

class TacosModel extends Model
{
    protected $id;
    protected $nom;
    protected $solo;
    protected $menu;
    protected $description;
    protected $img;



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
     * Get the value of prix_solo
     */
    public function getSolo()
    {
        return $this->solo;
    }

    /**
     * Set the value of prix_solo
     *
     * @return  self
     */
    public function setSolo($solo)
    {
        $this->solo = $solo;

        return $this;
    }

    /**
     * Get the value of prix_menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set the value of prix_menu
     *
     * @return  self
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }
}
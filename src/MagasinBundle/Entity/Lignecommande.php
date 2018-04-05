<?php

namespace MagasinBundle\Entity;

/**
 * Lignecommande
 */
class Lignecommande
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $idcommande;

    /**
     * @var int
     */
    private $idproduit;

    /**
     * @var int
     */
    private $quantite;

    /**
     * @var float
     */
    private $prix;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idcommande
     *
     * @param integer $idcommande
     *
     * @return Lignecommande
     */
    public function setIdcommande($idcommande)
    {
        $this->idcommande = $idcommande;

        return $this;
    }

    /**
     * Get idcommande
     *
     * @return int
     */
    public function getIdcommande()
    {
        return $this->idcommande;
    }

    /**
     * Set idproduit
     *
     * @param integer $idproduit
     *
     * @return Lignecommande
     */
    public function setIdproduit($idproduit)
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    /**
     * Get idproduit
     *
     * @return int
     */
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Lignecommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Lignecommande
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }
}


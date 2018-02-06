<?php

namespace MagasinBundle\Entity;

/**
 * Commande
 */
class Commande
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $etat;

    /**
     * @var float
     */
    private $prix;

    /**
     * @var \DateTime
     */
    private $dateliv;

    /**
     * @var float
     */
    private $prixliv;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Commande
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

    /**
     * Set dateliv
     *
     * @param \DateTime $dateliv
     *
     * @return Commande
     */
    public function setDateliv($dateliv)
    {
        $this->dateliv = $dateliv;

        return $this;
    }

    /**
     * Get dateliv
     *
     * @return \DateTime
     */
    public function getDateliv()
    {
        return $this->dateliv;
    }

    /**
     * Set prixliv
     *
     * @param float $prixliv
     *
     * @return Commande
     */
    public function setPrixliv($prixliv)
    {
        $this->prixliv = $prixliv;

        return $this;
    }

    /**
     * Get prixliv
     *
     * @return float
     */
    public function getPrixliv()
    {
        return $this->prixliv;
    }
}


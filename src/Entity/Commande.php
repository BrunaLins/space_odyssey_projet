<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbre_personne;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_final;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sejour", inversedBy="commandes")
     *
     */
    private $sejour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeHebergement", inversedBy="commandes")
     *
     */
    private $type_hebergement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hebergement", inversedBy="commandes")
     *
     */
    private $hebergement;

    public function __construct()
    {
/*        $this->commandes = new ArrayCollection();
        $this->comments = new ArrayCollection();*/
        $this->date_commande = new \DateTime('+10years');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrePersonne(): ?int
    {
        return $this->nbre_personne;
    }

    public function setNbrePersonne(int $nbre_personne): self
    {
        $this->nbre_personne = $nbre_personne;

        return $this;
    }

    public function getPrixFinal(): ?int
    {
        return $this->prix_final;
    }

    public function setPrixFinal(int $prix_final): self
    {
        $this->prix_final = $prix_final;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSejour(): ?Sejour
    {
        return $this->sejour;
    }

    public function setSejour(?Sejour $sejour): self
    {
        $this->sejour = $sejour;

        return $this;
    }

    public function getTypeHebergement(): ?TypeHebergement
    {
        return $this->type_hebergement;
    }

    public function setTypeHebergement(?TypeHebergement $type_hebergement): self
    {
        $this->type_hebergement = $type_hebergement;

        return $this;
    }

    public function getHebergement(): ?Hebergement
    {
        return $this->hebergement;
    }

    public function setHebergement(?Hebergement $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }
}

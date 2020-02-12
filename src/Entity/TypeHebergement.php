<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeHebergementRepository")
 */
class TypeHebergement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_type_hebergement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixTypeHebergement(): ?int
    {
        return $this->prix_type_hebergement;
    }

    public function setPrixTypeHebergement(int $prix_type_hebergement): self
    {
        $this->prix_type_hebergement = $prix_type_hebergement;

        return $this;
    }
}

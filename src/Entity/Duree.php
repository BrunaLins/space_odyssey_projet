<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DureeRepository")
 */
class Duree
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
    private $nbre_jours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sejour", mappedBy="dureedata")
     */
    private $sejours;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

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

    public function getNbreJours(): ?int
    {
        return $this->nbre_jours;
    }

    public function setNbreJours(int $nbre_jours): self
    {
        $this->nbre_jours = $nbre_jours;

        return $this;
    }

    /**
     * @return Collection|Sejour[]
     */
    public function getSejours(): Collection
    {
        return $this->sejours;
    }

    public function addSejour(Sejour $sejour): self
    {
        if (!$this->sejours->contains($sejour)) {
            $this->sejours[] = $sejour;
            $sejour->setDureedata($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejours->contains($sejour)) {
            $this->sejours->removeElement($sejour);
            // set the owning side to null (unless already changed)
            if ($sejour->getDureedata() === $this) {
                $sejour->setDureedata(null);
            }
        }

        return $this;
    }
}

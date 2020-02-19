<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DestinationRepository")
 */
class Destination
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
     * @ORM\OneToMany(targetEntity="App\Entity\Sejour", mappedBy="destination")
     */
    private $sejours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hebergement", mappedBy="destination")
     */
    private $hebergements;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $destination_premium;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
        $this->hebergements = new ArrayCollection();
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
            $sejour->setDestination($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejours->contains($sejour)) {
            $this->sejours->removeElement($sejour);
            // set the owning side to null (unless already changed)
            if ($sejour->getDestination() === $this) {
                $sejour->setDestination(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Hebergement[]
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
    }

    public function addHebergement(Hebergement $hebergement): self
    {
        if (!$this->hebergements->contains($hebergement)) {
            $this->hebergements[] = $hebergement;
            $hebergement->setDestination($this);
        }

        return $this;
    }

    public function removeHebergement(Hebergement $hebergement): self
    {
        if ($this->hebergements->contains($hebergement)) {
            $this->hebergements->removeElement($hebergement);
            // set the owning side to null (unless already changed)
            if ($hebergement->getDestination() === $this) {
                $hebergement->setDestination(null);
            }
        }

        return $this;
    }

    public function getDestinationPremium(): ?bool
    {
        return $this->destination_premium;
    }

    public function setDestinationPremium(?bool $destination_premium): self
    {
        $this->destination_premium = $destination_premium;

        return $this;
    }
}

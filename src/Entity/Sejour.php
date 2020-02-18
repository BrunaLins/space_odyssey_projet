<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SejourRepository")
 */
class Sejour
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="date")
     */
    private $mois_depart;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Image(mimeTypesMessage="Le fichier doit être une image", maxSize="5M", maxSizeMessage="L'image be doit pas dépasser 5Mo")
     */
    private $image_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_3;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_sejour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Destination", inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeHebergement", inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_hebergement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="sejour")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="sejour",cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Duree", inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dureedata;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $promo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $moyenne;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->mois_depart = new \DateTime();
        $this->duree = 0; // en attente de suppression
        $this->prix_sejour = 0; // en attente de suppression
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getMoisDepart(): ?\DateTimeInterface
    {
        return $this->mois_depart;
    }

    public function setMoisDepart(\DateTimeInterface $mois_depart): self
    {
        $this->mois_depart = $mois_depart;

        return $this;
    }

    public function getImage1()
    {
        return $this->image_1;
    }

    public function setImage1($image_1): self
    {
        $this->image_1 = $image_1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image_2;
    }

    public function setImage2(?string $image_2): self
    {
        $this->image_2 = $image_2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image_3;
    }

    public function setImage3(?string $image_3): self
    {
        $this->image_3 = $image_3;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrixSejour(): ?int
    {
        return $this->prix_sejour;
    }

    public function setPrixSejour(int $prix_sejour): self
    {
        $this->prix_sejour = $prix_sejour;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;

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

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setSejour($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getSejour() === $this) {
                $commande->setSejour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setSejour($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getSejour() === $this) {
                $comment->setSejour(null);
            }
        }

        return $this;
    }

    public function getDureedata(): ?Duree
    {
        return $this->dureedata;
    }

    public function setDureedata(?Duree $dureedata): self
    {
        $this->dureedata = $dureedata;

        return $this;
    }

    public function getPromo(): ?int
    {
        return $this->promo;
    }

    public function setPromo(?int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getMoyenne(): ?int
    {
        return $this->moyenne;
    }

    public function setMoyenne(?int $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getNoteMoyenne()
    {
        $total = 0;

        foreach ($this->getComments() as $comment) {
            $total += $comment->getNote();
        }

        return $total / $this->getComments()->count();
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Materiaux
 *
 * @ORM\Table(name="materiaux")
 * @ORM\Entity
 */
class Materiaux
{
    /**
     
     *
     * @ORM\Column(name="materiaux_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $materiauxId;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="quantite", type="decimal", precision=5, scale=0, nullable=false)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="materiaux", orphanRemoval=true,cascade={"persist"})
     
     */
    private $image;
    public function __construct()
    {
        
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
        $this->image_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->materiauxId;
    }

    public function getMateriauxId(): ?int
    {
        return $this->materiauxId;
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

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

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

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setMateriaux($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getMateriaux() === $this) {
                $image->setMateriaux(null);
            }
        }

        return $this;
    }
    

}

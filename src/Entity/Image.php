<?php

namespace App\Entity;

use App\Entity\Materiaux;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image", indexes={@ORM\Index(name="IDX_C53D045FDA0D4E2", columns={"materiaux_id"})})
 * @ORM\Entity
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $imageId;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=200, nullable=false)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var \Materiaux
     *
     * @ORM\ManyToOne(targetEntity="Materiaux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="materiaux_id", referencedColumnName="materiaux_id")
     * })
     */
    private $materiaux;

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
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

  /*  public function getMateriaux(): ?Materiaux
    {
        return $this->materiaux;
    }

    public function setMateriaux(?Materiaux $materiaux): self
    {
        $this->materiaux = $materiaux;

        return $this;
    }

*/
}

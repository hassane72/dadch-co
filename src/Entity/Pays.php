<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaysRepository")
 */
class Pays
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alpha2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alpha3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomFr;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Etude", mappedBy="pays")
     */
    private $etude;

    public function __construct()
    {
        $this->etude = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(string $alpha2): self
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    public function getAlpha3(): ?string
    {
        return $this->alpha3;
    }

    public function setAlpha3(string $alpha3): self
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    public function getNomEn(): ?string
    {
        return $this->nomEn;
    }

    public function setNomEn(string $nomEn): self
    {
        $this->nomEn = $nomEn;

        return $this;
    }

    public function getNomFr(): ?string
    {
        return $this->nomFr;
    }

    public function setNomFr(string $nomFr): self
    {
        $this->nomFr = $nomFr;

        return $this;
    }

    /**
     * @return Collection|Etude[]
     */
    public function getEtude(): Collection
    {
        return $this->etude;
    }

    public function addEtude(Etude $etude): self
    {
        if (!$this->etude->contains($etude)) {
            $this->etude[] = $etude;
        }

        return $this;
    }

    public function removeEtude(Etude $etude): self
    {
        if ($this->etude->contains($etude)) {
            $this->etude->removeElement($etude);
        }

        return $this;
    }
}

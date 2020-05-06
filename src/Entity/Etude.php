<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Etude
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=255, minMessage="Le champs doit faire plus de 2 caractéres !",
     * maxMessage="Le titre ne peut pas faire plus de 255 caractéres")
     */
    private $compagny;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfStudy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100, minMessage="Votre description doit faire plus de 100 caractéres")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secteur;

    /**
     * @ORM\Column(type="string")
     *  @Assert\Regex(
     *     pattern     = "/^[1-9]\d{3}$/",
     *     message="la periode doit etre au bon format"
     * )
     */
    private $periode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageEtude", mappedBy="etude")
     * @Assert\Valid()
     */
    private $imageEtudes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pays", inversedBy="etude")
     */
    private $pays;

    public function __construct()
    {
        $this->imageEtudes = new ArrayCollection();
        $this->pays = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug() {
        if(empty($this->slug)) {
            $slug = new Slugify();
            $this->slug = $slug->slugify($this->subject);        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompagny(): ?string
    {
        return $this->compagny;
    }

    public function setCompagny(string $compagny): self
    {
        $this->compagny = $compagny;

        return $this;
    }

    public function getTypeOfStudy(): ?string
    {
        return $this->typeOfStudy;
    }

    public function setTypeOfStudy(string $typeOfStudy): self
    {
        $this->typeOfStudy = $typeOfStudy;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|ImageEtude[]
     */
    public function getImageEtudes(): Collection
    {
        return $this->imageEtudes;
    }

    public function addImageEtude(ImageEtude $imageEtude): self
    {
        if (!$this->imageEtudes->contains($imageEtude)) {
            $this->imageEtudes[] = $imageEtude;
            $imageEtude->setEtude($this);
        }

        return $this;
    }

    public function removeImageEtude(ImageEtude $imageEtude): self
    {
        if ($this->imageEtudes->contains($imageEtude)) {
            $this->imageEtudes->removeElement($imageEtude);
            // set the owning side to null (unless already changed)
            if ($imageEtude->getEtude() === $this) {
                $imageEtude->setEtude(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pays[]
     */
    public function getPays(): Collection
    {
        return $this->pays;
    }

    public function addPay(Pays $pay): self
    {
        if (!$this->pays->contains($pay)) {
            $this->pays[] = $pay;
            $pay->addEtude($this);
        }

        return $this;
    }

    public function removePay(Pays $pay): self
    {
        if ($this->pays->contains($pay)) {
            $this->pays->removeElement($pay);
            $pay->removeEtude($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeBlogRepository")
 */
class TypeBlog
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Blog", mappedBy="typeBlog")
     */
    private $blog;

    public function __construct()
    {
        $this->blog = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlog(): Collection
    {
        return $this->blog;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blog->contains($blog)) {
            $this->blog[] = $blog;
            $blog->setTypeBlog($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blog->contains($blog)) {
            $this->blog->removeElement($blog);
            // set the owning side to null (unless already changed)
            if ($blog->getTypeBlog() === $this) {
                $blog->setTypeBlog(null);
            }
        }

        return $this;
    }
}

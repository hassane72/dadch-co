<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 * @ORM\HasLifecycleCallbacks
 *  @UniqueEntity(
 * fields={"title"},
 * message="Une autre annonce possede deja ce titre, merci de le modifier"
 * )
 */
class Blog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=255, minMessage="Le titre doit faire plus de 10 caractéres !",
     * maxMessage="Le titre ne peut pas faire plus de 255 caractéres")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     *  @Assert\Length(min=20, minMessage="Votre introduction doit faire plus de 20 caractéres")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100, minMessage="Votre description doit faire plus de 100 caractéres")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $coverImage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageBlog", mappedBy="blog", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $imageBlogs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeBlog", inversedBy="blog")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeBlog;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="blogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="blog", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->imageBlogs = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

     /**
     * Permet de calculer la note moyenne d'un commentaire
     *
     * @return float
     */
    public function getAvgRatings() {
        $sum = array_reduce($this->comments->toArray(),function($total, $comment) {
            return $total + $comment->getRating();
        }, 0);
        if(count($this->comments) > 0) return $moyenne = $sum / count($this->comments);
        return 0;
    }

    /**
     * Permet de mettre en place la date de création
     *@ORM\PrePersist
     * @return void
     */
    public function prePersist() {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
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
            $this->slug = $slug->slugify($this->title);        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @return Collection|ImageBlog[]
     */
    public function getImageBlogs(): Collection
    {
        return $this->imageBlogs;
    }

    public function addImageBlog(ImageBlog $imageBlog): self
    {
        if (!$this->imageBlogs->contains($imageBlog)) {
            $this->imageBlogs[] = $imageBlog;
            $imageBlog->setBlog($this);
        }

        return $this;
    }

    public function removeImageBlog(ImageBlog $imageBlog): self
    {
        if ($this->imageBlogs->contains($imageBlog)) {
            $this->imageBlogs->removeElement($imageBlog);
            // set the owning side to null (unless already changed)
            if ($imageBlog->getBlog() === $this) {
                $imageBlog->setBlog(null);
            }
        }

        return $this;
    }

    public function getTypeBlog(): ?TypeBlog
    {
        return $this->typeBlog;
    }

    public function setTypeBlog(?TypeBlog $typeBlog): self
    {
        $this->typeBlog = $typeBlog;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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
            $comment->setBlog($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getBlog() === $this) {
                $comment->setBlog(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;


class Search
{ 

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=255, minMessage="Le titre doit faire plus de 10 caractéres !",
     * maxMessage="Le titre ne peut pas faire plus de 255 caractéres")
     */
    private $search;

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(string $search): self
    {
        $this->search = $search;

        return $this;
    }
}

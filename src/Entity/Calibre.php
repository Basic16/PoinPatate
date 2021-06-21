<?php

namespace App\Entity;

use App\Repository\CalibreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalibreRepository::class)
 */
class Calibre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $calibre;

    /**
     * @ORM\ManyToMany(targetEntity=Variete::class, mappedBy="idCalibre")
     */
    private $varietes;

    public function __construct()
    {
        $this->varietes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalibre(): ?string
    {
        return $this->calibre;
    }

    public function setCalibre(string $calibre): self
    {
        $this->calibre = $calibre;

        return $this;
    }

    /**
     * @return Collection|Variete[]
     */
    public function getVarietes(): Collection
    {
        return $this->varietes;
    }

    public function addVariete(Variete $variete): self
    {
        if (!$this->varietes->contains($variete)) {
            $this->varietes[] = $variete;
            $variete->addIdCalibre($this);
        }

        return $this;
    }

    public function removeVariete(Variete $variete): self
    {
        if ($this->varietes->removeElement($variete)) {
            $variete->removeIdCalibre($this);
        }

        return $this;
    }
}

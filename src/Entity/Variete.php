<?php

namespace App\Entity;

use App\Repository\VarieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=VarieteRepository::class)
 * @ApiResource()
 */
class Variete
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=Calibre::class, inversedBy="varietes")
     */
    private $idCalibre;

    /**
     * @ORM\ManyToMany(targetEntity=Frigos::class, mappedBy="idVariete")
     */
    private $frigos;

    public function __construct()
    {
        $this->idCalibre = new ArrayCollection();
        $this->frigos = new ArrayCollection();
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Calibre[]
     */
    public function getIdCalibre(): Collection
    {
        return $this->idCalibre;
    }

    public function addIdCalibre(Calibre $idCalibre): self
    {
        if (!$this->idCalibre->contains($idCalibre)) {
            $this->idCalibre[] = $idCalibre;
        }

        return $this;
    }

    public function removeIdCalibre(Calibre $idCalibre): self
    {
        $this->idCalibre->removeElement($idCalibre);

        return $this;
    }

    /**
     * @return Collection|Frigos[]
     */
    public function getFrigos(): Collection
    {
        return $this->frigos;
    }

    public function addFrigo(Frigos $frigo): self
    {
        if (!$this->frigos->contains($frigo)) {
            $this->frigos[] = $frigo;
            $frigo->addIdVariete($this);
        }

        return $this;
    }

    public function removeFrigo(Frigos $frigo): self
    {
        if ($this->frigos->removeElement($frigo)) {
            $frigo->removeIdVariete($this);
        }

        return $this;
    }
}

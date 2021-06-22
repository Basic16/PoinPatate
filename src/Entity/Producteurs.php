<?php

namespace App\Entity;

use App\Repository\ProducteursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ProducteursRepository::class)
 * @ApiResource()
 */
class Producteurs
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
     * @ORM\Column(type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=Frigos::class, mappedBy="idProducteurs")
     */
    private $frigos;

    public function __construct()
    {
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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
            $frigo->addIdProducteur($this);
        }

        return $this;
    }

    public function removeFrigo(Frigos $frigo): self
    {
        if ($this->frigos->removeElement($frigo)) {
            $frigo->removeIdProducteur($this);
        }

        return $this;
    }
}

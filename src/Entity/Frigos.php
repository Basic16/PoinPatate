<?php

namespace App\Entity;

use App\Repository\FrigosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=FrigosRepository::class)
 * @ApiResource()
 */
class Frigos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CSV;

    /**
     * @ORM\Column(type="integer")
     */
    private $Stockage;

    /**
     * @ORM\ManyToMany(targetEntity=Variete::class, inversedBy="frigos")
     */
    private $idVariete;

    /**
     * @ORM\ManyToMany(targetEntity=Producteurs::class, inversedBy="frigos")
     */
    private $idProducteurs;

    public function __construct()
    {
        $this->idVariete = new ArrayCollection();
        $this->idProducteurs = new ArrayCollection();
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

    public function getCSV(): ?string
    {
        return $this->CSV;
    }

    public function setCSV(string $CSV): self
    {
        $this->CSV = $CSV;

        return $this;
    }

    public function getStockage(): ?int
    {
        return $this->Stockage;
    }

    public function setStockage(int $Stockage): self
    {
        $this->Stockage = $Stockage;

        return $this;
    }

    /**
     * @return Collection|Variete[]
     */
    public function getIdVariete(): Collection
    {
        return $this->idVariete;
    }

    public function addIdVariete(Variete $idVariete): self
    {
        if (!$this->idVariete->contains($idVariete)) {
            $this->idVariete[] = $idVariete;
        }

        return $this;
    }

    public function removeIdVariete(Variete $idVariete): self
    {
        $this->idVariete->removeElement($idVariete);

        return $this;
    }

    /**
     * @return Collection|Producteurs[]
     */
    public function getIdProducteurs(): Collection
    {
        return $this->idProducteurs;
    }

    public function addIdProducteur(Producteurs $idProducteur): self
    {
        if (!$this->idProducteurs->contains($idProducteur)) {
            $this->idProducteurs[] = $idProducteur;
        }

        return $this;
    }

    public function removeIdProducteur(Producteurs $idProducteur): self
    {
        $this->idProducteurs->removeElement($idProducteur);

        return $this;
    }
}

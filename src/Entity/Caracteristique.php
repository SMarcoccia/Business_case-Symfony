<?php

namespace App\Entity;

use App\Repository\CaracteristiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaracteristiqueRepository::class)
 */
class Caracteristique
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
    private $caracteristique;

    /**
     * @ORM\OneToMany(targetEntity=CaracteristiqueValeur::class, mappedBy="caracteristique")
     */
    private $caracteristiqueValeurs;

    public function __construct()
    {
        $this->caracteristiqueValeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    /**
     * @return Collection|CaracteristiqueValeur[]
     */
    public function getCaracteristiqueValeurs(): Collection
    {
        return $this->caracteristiqueValeurs;
    }

    public function addCaracteristiqueValeur(CaracteristiqueValeur $caracteristiqueValeur): self
    {
        if (!$this->caracteristiqueValeurs->contains($caracteristiqueValeur)) {
            $this->caracteristiqueValeurs[] = $caracteristiqueValeur;
            $caracteristiqueValeur->setCaracteristique($this);
        }

        return $this;
    }

    public function removeCaracteristiqueValeur(CaracteristiqueValeur $caracteristiqueValeur): self
    {
        if ($this->caracteristiqueValeurs->removeElement($caracteristiqueValeur)) {
            // set the owning side to null (unless already changed)
            if ($caracteristiqueValeur->getCaracteristique() === $this) {
                $caracteristiqueValeur->setCaracteristique(null);
            }
        }

        return $this;
    }
}

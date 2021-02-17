<?php

namespace App\Entity;

use App\Repository\ModeleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ModeleRepository::class)
 */
class Modele
{
    /**
     * @Groups("detail_modele")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"list_ads", "detail_ad", "list_modele", "detail_modele", "list_modelesByIdMarque"})
     * @ORM\Column(type="string", length=50)
     */
    private $modele;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="modele")
     */
    private $annonces;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="modeles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity=Carburant::class, inversedBy="modeles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carburant;

    /**
     * @Groups("detail_ad")
     * @ORM\OneToMany(targetEntity=CaracteristiqueValeur::class, mappedBy="modele")
     */
    private $caracteristiqueValeurs;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->caracteristiqueValeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setModele($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getModele() === $this) {
                $annonce->setModele(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getCarburant(): ?Carburant
    {
        return $this->carburant;
    }

    public function setCarburant(?Carburant $carburant): self
    {
        $this->carburant = $carburant;

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
            $caracteristiqueValeur->setModele($this);
        }

        return $this;
    }

    public function removeCaracteristiqueValeur(CaracteristiqueValeur $caracteristiqueValeur): self
    {
        if ($this->caracteristiqueValeurs->removeElement($caracteristiqueValeur)) {
            // set the owning side to null (unless already changed)
            if ($caracteristiqueValeur->getModele() === $this) {
                $caracteristiqueValeur->setModele(null);
            }
        }

        return $this;
    }
}

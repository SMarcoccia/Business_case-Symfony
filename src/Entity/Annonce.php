<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @Groups({"list_ads", "detail_ad"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"list_ads", "detail_ad"})
     * @ORM\Column(type="integer")
     */
    private $annee;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="integer")
     */
    private $kilometrage;

    /**
     * @Groups({"list_ads", "detail_ad"})
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="string", length=10)
     */
    private $immatriculation;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="string", length=10)
     */
    private $garantie;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="integer")
     */
    private $reference;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"list_ads", "detail_ad"})
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @Groups({"list_ads", "detail_ad"})
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    /**
     * @Groups("detail_ad")
     * @ORM\ManyToOne(targetEntity=Carburant::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carburant;

    /**
     * @ORM\ManyToOne(targetEntity=Garage::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $garage;

    /**
     * @Groups({"list_ads", "detail_ad"})
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="annonce")
     */
    private $photos;


    public function __construct()
    {
        $this->createdAt =  new \DateTime();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getReference(): ?int
    {
        return $this->reference;
    }

    public function setReference(int $reference): self
    {
        $this->reference = $reference;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

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

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setAnnonce($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getAnnonce() === $this) {
                $photo->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getGarantie(): ?string
    {
        return $this->garantie;
    }

    public function setGarantie(string $garantie): self
    {
        $this->garantie = $garantie;

        return $this;
    }
}

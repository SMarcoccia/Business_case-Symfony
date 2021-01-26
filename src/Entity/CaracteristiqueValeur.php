<?php

namespace App\Entity;

use App\Repository\CaracteristiqueValeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=CaracteristiqueValeurRepository::class)
 */
class CaracteristiqueValeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("detail_ad")
     * @ORM\Column(type="string", length=50)
     */
    private $valeur;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="caracteristiqueValeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    /**
     * @Groups("detail_ad")
     * @ORM\ManyToOne(targetEntity=Caracteristique::class, inversedBy="caracteristiqueValeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caracteristique;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

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

    public function getCaracteristique(): ?Caracteristique
    { 
        return $this->caracteristique;
    }

    public function setCaracteristique(?Caracteristique $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }
}

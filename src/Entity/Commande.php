<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usager = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class, cascade: ['persist', 'remove'])]
    private Collection $ligneCommandes;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $total = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbProduit = null;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    /**
     * @param \DateTimeInterface|null $dateCommande
     */
    public function setDateCommande(?\DateTimeInterface $dateCommande): void
    {
        $this->dateCommande = $dateCommande;
    }

    /**
     * @return string|null
     */
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    /**
     * @param string|null $statut
     */
    public function setStatut(?string $statut): void
    {
        $this->statut = $statut;
    }

    /**
     * @return User|null
     */
    public function getUsager(): ?User
    {
        return $this->usager;
    }

    /**
     * @param User|null $usager
     */
    public function setUsager(?User $usager): void
    {
        $this->usager = $usager;
    }

    /**
     * @return Collection
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    /**
     * @param Collection $ligneCommandes
     */
    public function setLigneCommandes(Collection $ligneCommandes): void
    {
        $this->ligneCommandes = $ligneCommandes;
    }

    /**
     * addLigneCommande
     */
    public function addLigneCommande(LigneCommande $ligneCommande): void
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;

        }

    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float|null $total
     */
    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int|null
     */
    public function getNbProduit(): ?int
    {
        return $this->nbProduit;
    }

    /**
     * @param int|null $nbProduit
     */
    public function setNbProduit(?int $nbProduit): void
    {
        $this->nbProduit = $nbProduit;
    }




}

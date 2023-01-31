<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
    private ?Produit $produit = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
    private ?Commande $commande = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    /**
     * @return Produit|null
     */
    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    /**
     * @param Produit|null $produit
     */
    public function setProduit(?Produit $produit): void
    {
        $this->produit = $produit;
    }



    /**
     * @return Commande|null
     */
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    /**
     * @param Commande|null $commande
     */
    public function setCommande(?Commande $commande): void
    {
        $this->commande = $commande;
    }

    /**
     * @return int|null
     */
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    /**
     * @param int|null $quantite
     */
    public function setQuantite(?int $quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return float|null
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * @param float|null $prix
     */
    public function setPrix(?float $prix): void
    {
        $this->prix = $prix;
    }


}

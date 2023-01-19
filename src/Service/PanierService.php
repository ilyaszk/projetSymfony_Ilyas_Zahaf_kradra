<?php

namespace App\Service;

use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier
    private $session; // Le service Session
    private $boutique; // Le service Boutique
    private $panier; // Tableau associatif idProduit => quantite
    // donc $this->panier[$i] = quantite du produit dont l'id = $i
    // constructeur du service

    public function __construct(RequestStack $requestStack, BoutiqueService $boutique){
        $this->panier = Array();
        // Récupération des services session et BoutiqueService
        $this->boutique = $boutique;
        $this->session = $requestStack->getSession();
        // Récupération du panier en session s'il existe, init. à vide sinon
        if ($this->session->has(self::PANIER_SESSION)) {
            $this->panier = $this->session->get(self::PANIER_SESSION);
        } else {
            $this->session->set(self::PANIER_SESSION, $this->panier);
        }
    }


    // getContenu renvoie le contenu du panier
    // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu()
    { // à compléter
        $contenu = [];
        if (sizeof($this->panier) > 0) {
            foreach ($this->panier as $idProduit => $quantite) {
                $produit = $this->boutique->findProduitById($idProduit);
                $contenu[] = ["produit" => $produit, "quantite" => $quantite];
            }
        }
        return $contenu;
    }

    // getTotal renvoie le montant total du panier
    public function getTotal()
    { // à compléter
        $total = 0;
        if (sizeof($this->panier) > 0) {
            foreach ($this->panier as $idProduit => $quantite) {
                $produit = $this->boutique->findProduitById($idProduit);
                $total += $produit->prix * $quantite;
            }
        }
        return $total;
    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public
    function getNbProduits()
    { // à compléter
        $nb = 0;
        foreach ($this->panier as $id => $quantite) {
            $nb += $quantite;
        }
        return $nb;
    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
//Tableau associatif idProduit => quantite
    public
    function ajouterProduit(int $idProduit, int $quantite = 1)
    { // à compléter
        if (array_key_exists($idProduit, $this->panier)) {
            $this->panier[$idProduit] += $quantite;
        } else {
            $this->panier[$idProduit] = $quantite;
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public
    function enleverProduit(int $idProduit, int $quantite = 1)
    { // à compléter
        if (isset($this->panier[$idProduit])) {
            $this->panier[$idProduit] -= $quantite;
            if ($this->panier[$idProduit] <= 0) {
                unset($this->panier[$idProduit]);
            }
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public
    function supprimerProduit(int $idProduit)
    { // à compléter
        if (isset($this->panier[$idProduit])) {
            unset($this->panier[$idProduit]);
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // vider vide complètement le panier
    public
    function vider()
    { // à compléter
        $this->panier = [];
    }

}
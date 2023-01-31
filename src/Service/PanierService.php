<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier
    private $session; // Le service Session
    private $boutique; // Le service Boutique
    private $panier; // Tableau associatif idProduit => quantite
    // donc $this->panier[$i] = quantite du produit dont l'id = $i
    // constructeur du service

    public function __construct(RequestStack $requestStack, ProduitRepository $boutique)
    {
        $this->panier = array();
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
                $total += $produit->getPrix() * $quantite;

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
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    //Ajouter une nouvelle méthode panierToCommande qui reçoit en paramètre une entité de type Usager et qui
    //crée, pour cet usager, une commande (et ses lignes de commande) à partir du contenu du panier (s’il n’est pas
    //vide).
    //o Le contenu du panier devra être supprimé à l’issue de ce traitement.
    //o Cette méthode renverra en résultat l’entité Commande qui aura été créée.

    public function panierToCommande($user, EntityManagerInterface $em) : void{

        $commande = new Commande();
        $total = 0;
        $nbProduits = 0;
        $commande->setUsager($user);
        $commande->setDateCommande(new \DateTime());
        $commande->setStatut("En cours");
        $commande->setTotal(0);
        $commande->setNbProduit(0);

        foreach ($this->panier as $idProduit => $quantite) {
            $produit = $this->boutique->findProduitById($idProduit);
            $ligneCommande = new LigneCommande();
            $ligneCommande->setProduit($produit);
            $ligneCommande->setQuantite($quantite);
            $ligneCommande->setPrix($produit->getPrix()*$quantite);
            $ligneCommande->setCommande($commande);
            $total += $ligneCommande->getPrix();
            $nbProduits += $quantite;
            $commande->addLigneCommande($ligneCommande);
        }
        $commande->setTotal($total);
        $commande->setNbProduit($nbProduits);
        $em->persist($commande);
        $em->flush();
        $this->vider();
    }
}
<?php

namespace App\Controller;

use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique_categories')]
    public function boutique(BoutiqueService $boutiqueService ,PanierService $panierService): Response
    {
        $nbProduits = $panierService->getNbProduits();
        $categories = $boutiqueService->findAllCategories();
        return $this->render('pages/boutique.html.twig', [
            'categories' => $categories,
            'nbProduits' => $nbProduits
        ]);
    }

    #[Route('/boutique/{idCategorie}', name: 'app_boutique_produits')]
    public function produits(BoutiqueService $boutiqueService, int $idCategorie, PanierService $panierService): Response
    {
        $nbProduits = $panierService->getNbProduits();
        $produits = $boutiqueService->findProduitsByCategorie($idCategorie);
        return $this->render('pages/produits.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits' => $produits,
            'nbProduits' => $nbProduits
        ]);
    }
}

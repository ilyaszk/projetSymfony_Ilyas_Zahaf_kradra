<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique_categories')]
    public function boutique(CategorieRepository $boutiqueService): Response
    {
        $categories = $boutiqueService->findAllCategories();
        return $this->render('pages/boutique.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/boutique/{idCategorie}', name: 'app_boutique_produits')]
    public function produits(ProduitRepository $ProduitService, int $idCategorie): Response
    {
        $produits = $ProduitService->findAllProduitByCategorie($idCategorie);
        return $this->render('pages/produits.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits' => $produits,
        ]);
    }
    #[Route('/rechercheProduit', name: 'rechercheProduit')]
    public function rechercheProduit(ProduitRepository $ProduitService, Request $request): Response
    {
        $nomProduit = $request->query->get('searchString');
        $produits = $ProduitService->findAllProduitByName($nomProduit);
        return $this->render('pages/produitsRecherche.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits' => $produits,
        ]);
    }
}

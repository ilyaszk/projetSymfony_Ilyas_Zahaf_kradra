<?php

namespace App\Controller;


use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/nbProduits', name: 'app_nbProduits')]
    public function nbProduits(PanierService $panierService): Response
    {
        $nbProduits = $panierService->getNbProduits();
        return $this->render('components/nbProduits.html.twig', [
            'controller_name' => 'DefaultController',
            'nbProduits' => $nbProduits
        ]);
    }

    //top 5 des produits les plus vendus
    #[Route('/topProduits', name: 'app_top_produits')]
    public function topProduits(LigneCommandeRepository $ligneCommandeRepository): Response
    {
        $topProduits = $ligneCommandeRepository->findTopProduits();
        return $this->render('components/sideTopProduit.html.twig', [
            'controller_name' => 'DefaultController',
            'topProduits' => $topProduits
        ]);
    }
}

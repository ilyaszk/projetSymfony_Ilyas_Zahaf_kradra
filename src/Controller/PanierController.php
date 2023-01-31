<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(PanierService $panierService): Response
    {
        $produits = $panierService->getContenu();
        $total = $panierService->getTotal();
        return $this->render('pages/panier.html.twig', [
            'controller_name' => 'PanierController',
            'produits' => $produits,
            'total' => $total
        ]);
    }

    #[Route('/panier/ajouter_produit/{idProduit}', name: 'app_panier_ajouter')]
    public function ajouterProduit(PanierService $panierService, int $idProduit): Response
    {
        $panierService->ajouterProduit($idProduit);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/panierAddQuantite/{idProduit}', name: 'app_panier_addQuantite')]
    public function panierAddQuantite(PanierService $panierService, int $idProduit): Response
    {
        $panierService->ajouterProduit($idProduit);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/panierRemoveQuantite/{idProduit}', name: 'app_panier_removeQuantite')]
    public function panierRemoveQuantite(PanierService $panierService, int $idProduit): Response
    {
        $panierService->enleverProduit($idProduit);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/panierRemoveProduit/{idProduit}', name: 'app_panier_removeProduit')]
    public function panierRemoveProduit(PanierService $panierService, int $idProduit): Response
    {
        $panierService->supprimerProduit($idProduit);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/passerCommande', name: 'app_panier_passerCommande')]
    public function passerCommande(PanierService $panierService, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $panierService->panierToCommande($userRepository->getUser(), $entityManager);
        return $this->redirectToRoute('panier');
    }
}

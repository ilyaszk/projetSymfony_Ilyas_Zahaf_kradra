<?php

namespace App\Controller;

use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(PanierService $panierService): Response
    {
        $nbProduits = $panierService->getNbProduits();
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'DefaultController',
            'nbProduits' => $nbProduits
        ]);
    }
}

<?php

namespace App\Controller;

use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(PanierService $panierService): Response
    {
        $nbProduits = $panierService->getNbProduits();
        return $this->render('pages/contact.html.twig', [
            'controller_name' => 'ContactController',
            'nbProduits' => $nbProduits
        ]);
    }
}

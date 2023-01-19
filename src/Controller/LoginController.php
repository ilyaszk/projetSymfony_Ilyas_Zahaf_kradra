<?php

namespace App\Controller;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(PanierService $panierService): Response
    {
        $nbProduits = $panierService->getNbProduits();
        return $this->render('pages/login.html.twig', [
            'controller_name' => 'LoginController',
            'nbProduits' => $nbProduits
        ]);
    }

}
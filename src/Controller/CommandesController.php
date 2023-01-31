<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractController
{
    #[Route('/commandes', name: 'app_commandes')]
    public function commandes(CommandeRepository $commandes ): Response
    {
        $commandes = $commandes->findAll();
        return $this->render('pages/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}

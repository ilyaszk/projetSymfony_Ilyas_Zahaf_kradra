<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractController
{
    #[Route('/commandes', name: 'app_commandes')]
    public function commandes(CommandeRepository $commandes ): Response
    {
        $commandes = $commandes->findByUser($this->getUser());
        return $this->render('pages/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/cloreCommande/{id}', name: 'cloreCommande')]
    public function cloreCommande($id, CommandeRepository $commandes, EntityManagerInterface $em): Response
    {
        $commande = $commandes->find($id);
        $commande->setStatut('Terminée');
        $em->persist($commande);
        $em->flush();
        return $this->redirectToRoute('gererCommandes');
    }

    //supprimer une commande
    #[Route('/supprimerCommande/{id}', name: 'supprimerCommande')]
    public function supprimerCommande($id, CommandeRepository $commandes, EntityManagerInterface $em): Response
    {
        $commande = $commandes->find($id);
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('gererCommandes');
    }
}

<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\UserRepository;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Swift_Mailer;
use Swift_Message;
use Swift_SendmailTransport;
use Swift_SmtpTransport;
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
    public function passerCommande(PanierService $panierService, EntityManagerInterface $entityManager): Response
    {

        $commande = $panierService->panierToCommande($this->getUser(), $entityManager);
        $this->envoyerMail($this->getUser(), $commande);
        return $this->redirectToRoute('panier');
    }

    /**
     * @throws Exception
     */
    private function envoyerMail($user, $commande) {
        $subject = 'Confirmation de commande';
        $body = $this->render('emails/confirmation-commande.html.twig', [
            'user' => $user,
            'commande' => $commande
        ]);

        $mail = new PHPMailer(true);

        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ilyassymfony@gmail.com'; // Votre adresse e-mail Gmail
        $mail->Password = 'mcwedcdmhaifmrom'; // Votre mot de passe Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        // Destinataire
        $mail->setFrom('ilyassymfony@gmail.com', 'projet Symfony Commande');
        $mail->addAddress($user->getEmail(), $user->getNom() . ' ' . $user->getPrenom());

        // Contenu du message
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectionType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuriteController extends AbstractController
{
    #[Route(path: '/{_locale}/login', name: 'app_login', requirements: ['_locale' => '%app.supported_locales%'])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('userAccueil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $formConn = $this->createForm(ConnectionType::class, null, [
            'action' => $this->generateUrl('login'),
            'method' => 'POST'
        ]);

        $formConn->handleRequest($request);

        return $this->render('security/login.html.twig', [
            'formConn' => $formConn->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/{_locale}/register', name: 'app_register', requirements: ['_locale' => '%app.supported_locales%'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $user = new User();
        $formInscr = $this->createForm(InscriptionType::class, $user, [
            'action' => $this->generateUrl('register'),
            'method' => 'POST'
        ]);
        $formInscr->handleRequest($request);
        dump($request);
        if ($formInscr->isSubmitted() && $formInscr->isValid()) {

            $user->setRoles(['ROLE_CLIENT']);
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            try {
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Inscription réussie');
                return $this->redirectToRoute('login');
            } catch (Exception $e) {
                $this->addFlash('danger', 'Une erreur est survenue lors de l\'inscription');
                return $this->redirectToRoute('login');
            }
        }

        return $this->render('security/register.html.twig', [
            'formInscr' => $formInscr->createView(),
        ]);
    }

    #[Route(path: '/{_locale}/logout', name: 'app_logout', requirements: ['_locale' => '%app.supported_locales%'])]
    public function logout(): void
    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }
}

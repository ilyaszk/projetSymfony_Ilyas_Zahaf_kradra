<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectionType;
use App\Form\InscriptionType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/user', requirements: ['_locale' => '%app.supported_locales%'], defaults: ['_locale' => 'fr'])]
class UserController extends AbstractController
{
    #[Route('/userAccueil', name: 'app_user_index', methods: ['GET'])]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }
        $user = $this->getUser();


        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}


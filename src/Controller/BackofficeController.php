<?php

namespace App\Controller;


use App\Entity\Commande;
use App\Form\CategorieType;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class BackofficeController extends AbstractController
{
    #[Route('/backoffice', name: 'backoffice')]
    public function index(): Response
    {
        return $this->render('pages/backoffice.html.twig', [
        ]);
    }

    #[Route('/gererCommandes', name: 'gererCommandes')]
    public function gererCommandes(EntityManagerInterface $em)
    {
        $commandes = $em->getRepository(Commande::class)->findAll();
        return $this->render('pages/gestionCommandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    #[Route('/createCategory', name: 'createCategory')]
    public function createCategory(Request $request, EntityManagerInterface $em): Response
    {
        $formCate = $this->createForm(CategorieType::class);
        $formCate->handleRequest($request);

        if ($formCate->isSubmitted() && $formCate->isValid()) {
            $file = $formCate->get('visuel')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('upload_directory_categories'),
                $fileName
            );
            $formCate->getData()->setVisuel('images/categories/'.$fileName);
            $em->persist($formCate->getData());
            $em->flush();
        }

        return $this->render('pages/creationCategorie.html.twig', [
            'formCate' => $formCate->createView(),
        ]);
    }
    #[Route('/createProduct', name: 'createProduct')]
    public function createProduct(Request $request, EntityManagerInterface $em): Response
    {
        $formProd = $this->createForm(ProduitType::class);
        $formProd->handleRequest($request);

        if ($formProd->isSubmitted() && $formProd->isValid()) {
            $file = $formProd->get('visuel')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('upload_directory_produits'),
                    $fileName
                );
            $formProd->getData()->setVisuel('images/produits/'.$fileName);
            $em->persist($formProd->getData());
            $em->flush();
        }

        return $this->render('pages/creationProduit.html.twig', [
            'formProd' => $formProd->createView(),
        ]);
    }


}

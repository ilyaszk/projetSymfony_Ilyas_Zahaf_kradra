<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneCommande>
 *
 * @method LigneCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommande[]    findAll()
 * @method LigneCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommande::class);
    }

    public function save(LigneCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LigneCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LigneCommande[] Returns an array of LigneCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneCommande
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findTopProduits(): array
    {
        // #[ORM\Id]
        //    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
        //    private ?Produit $produit = null;
        //
        //    #[ORM\Id]
        //    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
        //    private ?Commande $commande = null;
        //
        //    #[ORM\Column]
        //    private ?int $quantite = null;
        //
        //    #[ORM\Column]
        //    private ?float $prix = null;
//        $query = 'Select p.id, p.libelle, p.prix, sum(l.quantite) as quantite from produit p, ligne_commande l where p.id = l.produit_id group by p.id order by quantite desc limit 5';
        //en dql

        return $this->createQueryBuilder('l')
            ->select('p.id, p.libelle, p.prix, p.visuel, c.id as categorie, sum(l.quantite) as quantite')
            ->join('l.produit', 'p')
            ->join('p.categorie', 'c')
            ->groupBy('p.id')
            ->orderBy('quantite', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
        }
}

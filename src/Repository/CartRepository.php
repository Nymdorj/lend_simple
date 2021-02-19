<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    // /**
    //  * @return Cart[] Returns an array of Cart objects
    //  */
    // public function findByUserId($userId)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->innerJoin('p.rooms', 'ap')
    //         ->andWhere('c.userid = :userid')
    //         ->setParameter('userid', $userId)
    //         ->getQuery()
    //         ->getResult();
    // }

    public function getCartItems($userId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c.id, c.productid, c.quantity, c.size, c.color, c.material,
                    p.name, p.price, p.description, p.brandname, p.image, 
                    c.quantity * p.price totalPrice
                FROM App\Entity\Cart c, App\Entity\Product p
            WHERE p.id = c.productid
                and c.userid = :userid
                and c.orderid is null
            ORDER BY p.id ASC'
        )->setParameter('userid', $userId);

        return $query->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Cart
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

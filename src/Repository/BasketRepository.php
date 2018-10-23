<?php

namespace App\Repository;

use App\Entity\Basket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Domain\BasketRepositoryInterface;

/**
 * @method Basket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Basket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Basket[]    findAll()
 * @method Basket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @Service('')
 */
class BasketRepository extends ServiceEntityRepository implements BasketRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function store(Basket $basket)
    {
        $this->getEntityManager()->persist($basket);
        $this->getEntityManager()->flush();
        $this->flush();
    }

    public function remove(int $id)
    {
        $basket = $this->find($id);

        if ($basket) {
            $this->getEntityManager()->remove($basket);
            $this->getEntityManager()->flush();
        }

        return $basket;
    }
}

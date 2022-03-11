<?php

namespace App\Repository\Admin\Cms;

use App\Entity\Cms\Page;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends EntityRepository
{
    public function findOnePublishedBySlug($slug)
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.status = 'published'")
            ->andWhere('p.slug = :slug')
            ->setParameter(':slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;

    }

    // /**
    //  * @return Page[] Returns an array of Pages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Page
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

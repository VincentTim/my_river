<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    public function getMostViewed(){
        $qb = $this->createQueryBuilder('u');
        $qb->select('u');
        $qb->join('u.category', 'c', 'WITH', $qb->expr()->eq('u.category', 'c.id'));
        $qb->addSelect('c');
        $qb->orderBy('u.view', 'DESC');
        $qb->setMaxResults( 3 );

        return $qb->getQuery()->getArrayResult();
    }

    public function getBy($tag){

        $qb = $this->createQueryBuilder('u');
        $qb->join('u.category', 'c', 'WITH', $qb->expr()->eq('u.category', 'c.id'));
        $qb->addSelect('c');
        $qb->join('u.files', 'f');
        $qb->addSelect('f');
        $qb->where($qb->expr()->like('u.description', ':param'));
        $qb->andWhere($qb->expr()->eq('f.post', 'u.id'));
        $qb->setParameter('param', '%#'.$tag.'%');

        return $qb->getQuery()->getArrayResult();
    }
}



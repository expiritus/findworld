<?php

namespace AdminBundle\Repository;

/**
 * FindRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FindRepository extends \Doctrine\ORM\EntityRepository
{
    public function desiredThing($data_id, $repository){
        return $this->getEntityManager()
            ->createQuery("SELECT t FROM ".$repository." t WHERE t.id = :data_id")
            ->setParameter('data_id', $data_id)
            ->getArrayResult();
    }

    public function getAllThings(){
        return $this->getEntityManager()
            ->createQuery("SELECT f FROM AdminBundle:Find f")
            ->getArrayResult();
    }

    public function getMatchByIds($ids_match_things){
        return $this->getEntityManager()
            ->createQuery("SELECT m FROM AdminBundle:Find m WHERE m.id IN (:ids)")
            ->setParameter('ids', $ids_match_things)
            ->getResult();
    }
}

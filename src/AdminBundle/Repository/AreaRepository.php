<?php

namespace AdminBundle\Repository;

/**
 * AreaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AreaRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAreaByCityId($city_id){
        return $this->getEntityManager()
            ->createQuery("SELECT c FROM AdminBundle:Area c WHERE c.cityId = :city_id")
            ->setParameter('city_id', $city_id)
            ->getArrayResult();

    }

    public function getAreaByName($area_name){
        return $this->getEntityManager()
            ->createQuery("SELECT a FROM AdminBundle:Area a WHERE a.area = :area_name")
            ->setParameter('area_name', $area_name)
            ->getResult();
    }
}

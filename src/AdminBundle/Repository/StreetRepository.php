<?php

namespace AdminBundle\Repository;

/**
 * StreetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StreetRepository extends \Doctrine\ORM\EntityRepository
{
    public function getStreetByAreaId($area_id){
        return $this->getEntityManager()
            ->createQuery("SELECT s FROM AdminBundle:Street s WHERE s.areaId = :area_id")
            ->setParameter('area_id', $area_id)
            ->getArrayResult();
    }

    public function getStreetByCityId($city_id){
        return $this->getEntityManager()
            ->createQuery("SELECT c FROM AdminBundle:Street c WHERE c.cityId = :city_id")
            ->setParameter('city_id', $city_id)
            ->getArrayResult();
    }

    public function getStreetByParent($parent_id){
        return $this->getEntityManager()
            ->createQuery("SELECT s FROM AdminBundle:Street s WHERE s.cityId = :city_id OR s.areaId = :area_id")
            ->setParameter('city_id', $parent_id['cityId'])
            ->setParameter('area_id', $parent_id['areaId'])
            ->getResult();

    }
}
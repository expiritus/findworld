<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="fw_area")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\AreaRepository")
 */
class Area
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=255)
     */
    private $area;

    /**
     * @var int
     *
     * @ORM\Column(name="city_id", type="integer")
     */
    private $cityId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set area
     *
     * @param string $area
     *
     * @return Area
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return Area
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
    }
}


<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     *
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="area")
     *
     * */
    protected $losts;



    /**
     *
     * @ORM\OneToMany(targetEntity="Find", mappedBy="area")
     *
     * */
    protected $finds;


    /**
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="areas")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     *
     * */
    protected $city;


    /**
     *
     * @ORM\OneToMany(targetEntity="Street", mappedBy="area")
     *
     * */
    protected $streets;


    public function __construct(){
        $this->losts = new ArrayCollection();
        $this->finds = new ArrayCollection();
        $this->streets = new ArrayCollection();
    }

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

    /**
     * Add lost
     *
     * @param \AdminBundle\Entity\Lost $lost
     *
     * @return Area
     */
    public function addLost(\AdminBundle\Entity\Lost $lost)
    {
        $this->losts[] = $lost;

        return $this;
    }

    /**
     * Remove lost
     *
     * @param \AdminBundle\Entity\Lost $lost
     */
    public function removeLost(\AdminBundle\Entity\Lost $lost)
    {
        $this->losts->removeElement($lost);
    }

    /**
     * Get losts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLosts()
    {
        return $this->losts;
    }

    /**
     * Add find
     *
     * @param \AdminBundle\Entity\Find $find
     *
     * @return Area
     */
    public function addFind(\AdminBundle\Entity\Find $find)
    {
        $this->finds[] = $find;

        return $this;
    }

    /**
     * Remove find
     *
     * @param \AdminBundle\Entity\Find $find
     */
    public function removeFind(\AdminBundle\Entity\Find $find)
    {
        $this->finds->removeElement($find);
    }

    /**
     * Get finds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFinds()
    {
        return $this->finds;
    }

    /**
     * Set city
     *
     * @param \AdminBundle\Entity\City $city
     *
     * @return Area
     */
    public function setCity(\AdminBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AdminBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add street
     *
     * @param \AdminBundle\Entity\Street $street
     *
     * @return Area
     */
    public function addStreet(\AdminBundle\Entity\Street $street)
    {
        $this->streets[] = $street;

        return $this;
    }

    /**
     * Remove street
     *
     * @param \AdminBundle\Entity\Street $street
     */
    public function removeStreet(\AdminBundle\Entity\Street $street)
    {
        $this->streets->removeElement($street);
    }

    /**
     * Get streets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStreets()
    {
        return $this->streets;
    }
}

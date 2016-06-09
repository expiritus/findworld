<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Street
 *
 * @ORM\Table(name="fw_street")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\StreetRepository")
 */
class Street
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
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="area_id", type="integer", nullable=true)
     */
    private $areaId;

    /**
     * @var int
     *
     * @ORM\Column(name="city_id", type="integer", nullable=true)
     */
    private $cityId;



    /**
     *
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="street")
     *
     *
     * */
    protected $losts;


    /**
     *
     * @ORM\OneToMany(targetEntity="Find", mappedBy="street")
     *
     * */
    protected $finds;


    /**
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="streets")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     *
     * */
    protected $city;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="streets")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     *
     * */
    protected $area;

    public function __construct(){
        $this->losts = new ArrayCollection();
        $this->finds = new ArrayCollection();
    }

    public function __toString(){
        return $this->street ? $this->street : "";
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
     * Set street
     *
     * @param string $street
     *
     * @return Street
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set areaId
     *
     * @param integer $areaId
     *
     * @return Street
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;

        return $this;
    }

    /**
     * Get areaId
     *
     * @return int
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Add lost
     *
     * @param \AdminBundle\Entity\Lost $lost
     *
     * @return Street
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
     * @return Street
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
     * Set area
     *
     * @param \AdminBundle\Entity\Area $area
     *
     * @return Street
     */
    public function setArea(\AdminBundle\Entity\Area $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \AdminBundle\Entity\Area
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
     * @return Street
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set city
     *
     * @param \AdminBundle\Entity\City $city
     *
     * @return Street
     */
    public function setCity(\AdminBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AdminBundle\Entity\Street
     */
    public function getCity()
    {
        return $this->city;
    }
}

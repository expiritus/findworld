<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="fw_city")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CityRepository")
 */
class City
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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="country_id", type="integer")
     */
    private $countryId;



    /**
     *
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="city")
     *
     * */
    protected $losts;


    /**
     *
     * @ORM\OneToMany(targetEntity="Find", mappedBy="city")
     *
     * */
    protected $finds;



    /**
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     *
     * */
    protected $country;


    /**
     *
     * @ORM\OneToMany(targetEntity="Area", mappedBy="city")
     *
     * */
    protected $areas;




    public function __construct(){
        $this->losts = new ArrayCollection();
        $this->finds = new ArrayCollection();
        $this->areas = new ArrayCollection();
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
     * Set city
     *
     * @param string $city
     *
     * @return City
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return City
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Add lost
     *
     * @param \AdminBundle\Entity\Lost $lost
     *
     * @return City
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
     * @return City
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
     * Set country
     *
     * @param \AdminBundle\Entity\Country $country
     *
     * @return City
     */
    public function setCountry(\AdminBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AdminBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add area
     *
     * @param \AdminBundle\Entity\Area $area
     *
     * @return City
     */
    public function addArea(\AdminBundle\Entity\Area $area)
    {
        $this->areas[] = $area;

        return $this;
    }

    /**
     * Remove area
     *
     * @param \AdminBundle\Entity\Area $area
     */
    public function removeArea(\AdminBundle\Entity\Area $area)
    {
        $this->areas->removeElement($area);
    }

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAreas()
    {
        return $this->areas;
    }
}

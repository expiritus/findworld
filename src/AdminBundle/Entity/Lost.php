<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lost
 *
 * @ORM\Table(name="fw_lost")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\LostRepository")
 */
class Lost
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
     * @var int
     *
     * @ORM\Column(name="thing_id", type="integer")
     */
    private $thingId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="country_id", type="integer", nullable=true)
     */
    private $countryId;

    /**
     * @var int
     *
     * @ORM\Column(name="city_id", type="integer", nullable=true)
     */
    private $cityId;

    /**
     * @var int
     *
     * @ORM\Column(name="area_id", type="integer", nullable=true)
     */
    private $areaId;

    /**
     * @var int
     *
     * @ORM\Column(name="street_id", type="integer", nullable=true)
     */
    private $streetId;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Thing", inversedBy="losts")
     * @ORM\JoinColumn(name="thing_id", referencedColumnName="id")
     *
     * */
    protected $thing;



    /**
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="losts")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     *
     * */
    protected $country;



    /**
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="losts")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     *
     * */
    protected $city;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="losts")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     *
     * */
    protected $area;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Street", inversedBy="losts")
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id")
     *
     * */
    protected $street;


    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="losts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * */
    protected $user;


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
     * Set thingId
     *
     * @param integer $thingId
     *
     * @return Lost
     */
    public function setThingId($thingId)
    {
        $this->thingId = $thingId;

        return $this;
    }

    /**
     * Get thingId
     *
     * @return int
     */
    public function getThingId()
    {
        return $this->thingId;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Lost
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Lost
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Lost
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return Lost
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
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return Lost
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
     * Set areaId
     *
     * @param integer $areaId
     *
     * @return Lost
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
     * Set streetId
     *
     * @param integer $streetId
     *
     * @return Lost
     */
    public function setStreetId($streetId)
    {
        $this->streetId = $streetId;

        return $this;
    }

    /**
     * Get streetId
     *
     * @return int
     */
    public function getStreetId()
    {
        return $this->streetId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Lost
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Lost
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Lost
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set thing
     *
     * @param \AdminBundle\Entity\Thing $thing
     *
     * @return Lost
     */
    public function setThing(\AdminBundle\Entity\Thing $thing = null)
    {
        $this->thing = $thing;

        return $this;
    }

    /**
     * Get thing
     *
     * @return \AdminBundle\Entity\Thing
     */
    public function getThing()
    {
        return $this->thing;
    }

    /**
     * Set country
     *
     * @param \AdminBundle\Entity\Country $country
     *
     * @return Lost
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
     * Set city
     *
     * @param \AdminBundle\Entity\City $city
     *
     * @return Lost
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
     * Set area
     *
     * @param \AdminBundle\Entity\Area $area
     *
     * @return Lost
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
     * Set street
     *
     * @param \AdminBundle\Entity\Street $street
     *
     * @return Lost
     */
    public function setStreet(\AdminBundle\Entity\Street $street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return \AdminBundle\Entity\Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set user
     *
     * @param \AdminBundle\Entity\User $user
     *
     * @return Lost
     */
    public function setUser(\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

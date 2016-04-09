<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Thing
 *
 * @ORM\Table(name="fw_thing")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ThingRepository")
 */
class Thing
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
     * @ORM\Column(name="thing", type="string", length=255)
     */
    private $thing;


    /**
     *
     * @ORM\Column(name="base_thing", type="boolean", nullable=true)
     *
     *
     * */
    private $baseThing;

    /**
     *
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="thing")
     *
     * */
    protected $losts;



    /**
     *
     * @ORM\OneToMany(targetEntity="Find", mappedBy="thing")
     *
     * */
    protected $finds;


    public function __construct(){
        $this->losts = new ArrayCollection();
        $this->finds = new ArrayCollection();
    }


    public function __toString(){
        return $this->thing ? $this->thing : "";
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
     * Add lost
     *
     * @param \AdminBundle\Entity\Lost $lost
     *
     * @return Thing
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
     * @return Thing
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
     * Set thing
     *
     * @param string $thing
     *
     * @return Thing
     */
    public function setThing($thing)
    {
        $this->thing = $thing;

        return $this;
    }

    /**
     * Get thing
     *
     * @return string
     */
    public function getThing()
    {
        return $this->thing;
    }

    /**
     * Set baseThing
     *
     * @param boolean $baseThing
     *
     * @return Thing
     */
    public function setBaseThing($baseThing)
    {
        $this->baseThing = $baseThing;

        return $this;
    }

    /**
     * Get baseThing
     *
     * @return boolean
     */
    public function getBaseThing()
    {
        return $this->baseThing;
    }
}

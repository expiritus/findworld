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
     * @ORM\Column(name="name_thing", type="string", length=255)
     */
    private $nameThing;

    /**
     *
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="nameThing")
     *
     * */
    protected $losts;



    /**
     *
     * @ORM\OneToMany(targetEntity="Find", mappedBy="nameThing")
     *
     * */
    protected $finds;


    public function __construct(){
        $this->losts = new ArrayCollection();
        $this->finds = new ArrayCollection();
    }


    public function __toString(){
        return $this->nameThing ? $this->nameThing : "";
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
     * Set nameThing
     *
     * @param string $nameThing
     *
     * @return Thing
     */
    public function setNameThing($nameThing)
    {
        $this->nameThing = $nameThing;

        return $this;
    }

    /**
     * Get nameThing
     *
     * @return string
     */
    public function getNameThing()
    {
        return $this->nameThing;
    }
}

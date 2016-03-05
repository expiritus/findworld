<?php

namespace AdminBundle\Entity;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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


<?php
namespace ICS\UserhelpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="userhelp")
 */
class IntroSaver
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;
    /**
     * @ORM\Column(type="string")
     */
    private $introRoute;


    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of introRoute
     */ 
    public function getIntroRoute()
    {
        return $this->introRoute;
    }

    /**
     * Set the value of introRoute
     *
     * @return  self
     */ 
    public function setIntroRoute($introRoute)
    {
        $this->introRoute = $introRoute;

        return $this;
    }
}
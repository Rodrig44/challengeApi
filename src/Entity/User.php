<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * Flag que indica si es organizador
     *
     * @var bool
     *
     * @ORM\Column(name="organizer", type="boolean", nullable=false)
     */
    private $organizer;

    /**
     * @var ArrayCollection|Activity[]
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Activity",
     *     mappedBy="organized",
     *     cascade={"remove"},
     *     orphanRemoval=true
     * )
     */
    private $organizedActivities;

    /**
     *
     * @var ArrayCollection|Activity[]
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Activity",
     *     cascade={"remove"}
     * )
     * @ORM\JoinTable(
     *     name="activities_users",
     *     joinColumns={
     *          @ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="activity", referencedColumnName="id", onDelete="CASCADE")
     *     }
     * )
     */
    private $activities;
    
    /**
     * construct User
     *
     * @param string $username
     * @param string|null $name
     * @param bool|false $organizer
     */
    public function __construct($username, $name = null, $organizer = false)
    {
        $this->username = $username;
        $this->name = $name;
        $this->organizer = $organizer;
    }

    /**
     * getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * getUsername
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * setUsername
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * getOrganizer
     *
     * @return bool
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * setOrganizer
     *
     * @param bool $organizer
     *
     * @return User
     */
    public function setOrganizer(bool $organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * getActivities
     *
     * @return Activity[]
     */
    public function getActivities()
    {
        return $this->activities;
    }

    public function addActivities(Activity $activity)
    {
        $this->activities[] = $activity;
    }

    /**
     * getOrganizedActivities
     *
     * @return Activity[]
     */
    public function getOrganizedActivities()
    {
        return $this->organizedActivities;
    }

    /**
     * @return string|null
    */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return array|string[]
    */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier()
    {
    }
}

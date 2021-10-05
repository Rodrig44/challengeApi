<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @var ArrayCollection|Activity[]
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Activity",
     *     mappedBy="category",
     *     cascade={"remove"},
     *     orphanRemoval=true
     * )
     */
    private $activities;

    /**
     * construct
     *
     * @param mixed $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
     * @return Category
     */
    public function setName(string $name)
    {
        $this->name = $name;

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
}

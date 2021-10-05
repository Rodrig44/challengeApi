<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="activities")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", onDelete="CASCADE")
     */
    private $category;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="activities")
     * @ORM\JoinColumn(name="organizer", referencedColumnName="id", onDelete="CASCADE")
     */
    private $organizer;

    /**
     * construct
     *
     * @param Category $category
     * @param User $organizer
     * @param string $name
     *
     */
    public function __construct(Category $category, User $organizer, $name)
    {
        $this->name = $name;
        $this->category = $category;
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
     * @return Activity
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getCategory
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * setCategory
     *
     * @param Category $category
     *
     * @return Activity
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * getOrganizer
     *
     * @return User
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * setOrganizer
     *
     * @param User $user
     *
     * @return Activity
     */
    public function setOrganizer(User $user)
    {
        $this->user = $user;

        return $this;
    }
}

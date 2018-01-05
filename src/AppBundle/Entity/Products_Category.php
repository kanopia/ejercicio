<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Products_Category
 */
class Products_Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="The field title cannot be empty")
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(message="The field title cannot be empty")
     * @Assert\Regex("/^[0-9a-zA-Z]+$/")
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="The field title cannot be empty")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Your name must be at least 2 characters long"
     * )
     */
    private $description;

    /**
     * @var bool
     * @Assert\NotBlank(message="The field title cannot be empty")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="Products", mappedBy="Products_Category")
     */
    private $Products;

    public function __construct()
    {
        $this->Products = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     *
     * @return Products_Category
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Products_Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Products_Category
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Products_Category
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }
}


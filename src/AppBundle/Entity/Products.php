<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Products
 */
class Products
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
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Your name must be at least 4 characters long",
     *      max = 10,
     *      maxMessage = "Your name cannot be longer than 10 characters"
     * )
     * @Assert\Regex("/^[0-9a-zA-Z]+$/")
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="The field title cannot be empty")
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Your name must be at least 4 characters long"
     * )
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message="The field title cannot be empty")
     */
    private $mark;

     /**
     * @ORM\ManyToOne(targetEntity="Products_Category", inversedBy="Products")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $Products_Category;

    /**
     * @var float
     * @Assert\NotBlank(message="The field title cannot be empty")
     * @Assert\Type(type="float", message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $price;


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
     * @return Products
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
     * @return Products
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
     * @return Products
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
     * Set mark
     *
     * @param string $mark
     *
     * @return Products
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}


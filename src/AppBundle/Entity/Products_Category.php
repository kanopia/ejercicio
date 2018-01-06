<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Products_Category
 *
 * @ORM\Table(name="products__category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Products_CategoryRepository")
 */
class Products_Category
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
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     * @Assert\Regex("/^[0-9a-zA-Z]+$/")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "El codigo debe de contener al menos {{ limit }} digitos"
     * )
     */
    private $nameCat;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="Products", mappedBy="products_category")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Set products
     *
     * @param  $products
     * @return products
     */
    public function setProducts($products)
    {
        $this->products = $products;
        
        return $this;
    }
    /**
     * Get products
     *
     * @return products
     */
    public function getProducts()
    {
        return $this->products;
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
     * Set nameCat
     *
     * @param string $nameCat
     *
     * @return Products_Category
     */
    public function setNameCat($nameCat)
    {
        $this->nameCat = $nameCat;

        return $this;
    }

    /**
     * Get nameCat
     *
     * @return string
     */
    public function getNameCat()
    {
        return $this->nameCat;
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
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }
}


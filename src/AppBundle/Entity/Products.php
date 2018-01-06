<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductsRepository")
 */
class Products
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
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "El codigo debe de contener al menos {{ limit }} digitos",
     *      max = 10,
     *      maxMessage = "El codigo debe de contener un maximo de {{ limit }} digitos"
     * )
     * @Assert\Regex("/^[0-9a-zA-Z]+$/",message="Ingresa solo caracteres alfanumericos")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "El codigo debe de contener al menos {{ limit }} digitos"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=255)
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     */
    private $mark;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank(message="El campo no puede estar vacio")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Products_Category", inversedBy="products")
     * @ORM\JoinColumn(name="category", nullable=false , referencedColumnName="id")
     */
    private $products_Category;

    /**
     * @var integer
     *
     * @ORM\Column(name="category", type="integer")
     */
    private $category;

     /**
     * Get category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }


    /** 
    * Get products_Category
    * 
    * @return int
    */

    public function getProductsCategory(){

        return $this->products_Category;
    }

    /**
    * Set products_Category
    * @param $products_Category
    * 
    * @return int
    */
    public function setProductsCategory($products_Category){

        $this->products_Category = $products_Category;
        
        return $this;
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


<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="cat", columns={"cat"}), @ORM\Index(name="cat_2", columns={"cat"}), @ORM\Index(name="cat_3", columns={"cat"})})
 * @ORM\Entity
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="short", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     */
    private $short;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="other_pics", type="string", length=1000, precision=0, scale=0, nullable=true, unique=false)
     */
    private $otherPics; 

    /**
     * @var integer
     *
     * @ORM\Column(name="rest", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rest;

    /**
     * @var \Application\Entity\Cats
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Cats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat", referencedColumnName="id", nullable=true)
     * })
     */
    private $cat;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Products
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set short
     *
     * @param string $short
     *
     * @return Products
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Get short
     *
     * @return string
     */
    public function getShort()
    {
        return $this->short;
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
     * Set price
     *
     * @param integer $price
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
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Products
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set otherPics
     *
     * @param string $otherPics
     *
     * @return Products
     */
    public function setOtherPics($otherPics)
    {
        $this->otherPics = $otherPics; 

        return $this;
    }

    /**
     * Get otherPics
     *
     * @return string
     */
    public function getOtherPics()
    {
        return $this->otherPics; 
    }

    /**
     * Set rest
     *
     * @param integer $rest
     *
     * @return Products
     */
    public function setRest($rest)
    {
        $this->rest = $rest;

        return $this;
    }

    /**
     * Get rest
     *
     * @return integer
     */
    public function getRest()
    {
        return $this->rest;
    }

    /**
     * Set cat
     *
     * @param \Application\Entity\Cats $cat
     *
     * @return Products
     */
    public function setCat(\Application\Entity\Cats $cat = null)
    {
        $this->cat = $cat;

        return $this;
    }

    /**
     * Get cat
     *
     * @return \Application\Entity\Cats
     */
    public function getCat()
    {
        return $this->cat;
    }
}


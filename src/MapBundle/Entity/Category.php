<?php

namespace MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MapBundle\Entity\Map;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MapBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;
    
    
    /**
     * @var text
     * 
     * @ORM\Column(name="description", type="text")
     */
    private $category_description;
    
    /**
     * @ORM\OneToMany(targetEntity="Map", mappedBy="category")
     */
    private $map;

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
     * Set name
     *
     * @param string $name
     * @return Category
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
     * Set category_description
     *
     * @param string $categoryDescription
     * @return Category
     */
    public function setCategoryDescription($categoryDescription)
    {
        $this->category_description = $categoryDescription;

        return $this;
    }

    /**
     * Get category_description
     *
     * @return string 
     */
    public function getCategoryDescription()
    {
        return $this->category_description;
    }
}

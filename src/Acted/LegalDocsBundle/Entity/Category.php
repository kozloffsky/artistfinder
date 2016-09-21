<?php

namespace Acted\LegalDocsBundle\Entity;

use Cocur\Slugify\Slugify;
use Acted\LegalDocsBundle\Entity\Recommend;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $lft;

    /**
     * @var integer
     */
    private $rgt;

    /**
     * @var integer
     */
    private $lvl;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Category
     */
    private $root;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Category
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $recommends;

    /**
     * @var boolean
     */
    private $isRecommend = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recommends = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Category
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
     * Set lft
     *
     * @param integer $lft
     *
     * @return Category
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return Category
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return Category
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Add child
     *
     * @param \Acted\LegalDocsBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\Acted\LegalDocsBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Acted\LegalDocsBundle\Entity\Category $child
     */
    public function removeChild(\Acted\LegalDocsBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set root
     *
     * @param \Acted\LegalDocsBundle\Entity\Category $root
     *
     * @return Category
     */
    public function setRoot(\Acted\LegalDocsBundle\Entity\Category $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return \Acted\LegalDocsBundle\Entity\Category
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \Acted\LegalDocsBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\Acted\LegalDocsBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Acted\LegalDocsBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * @var string
     */
    private $image;


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Category
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * @var string
     */
    private $slug;


    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
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
     * @var string
     */
    private $background;


    /**
     * Set background
     *
     * @param string $background
     *
     * @return Category
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Add recommend
     *
     * @param Recommend $recommend
     *
     * @return User
     */
    public function addRecommend(Recommend $recommend)
    {
        $this->recommends[] = $recommend;

        return $this;
    }

    /**
     * Remove recommend
     *
     * @param Recommend $recommend
     */
    public function removeRecommend(Recommend $recommend)
    {
        $this->recommends->removeElement($recommend);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getRecommends()
    {
        return $this->recommends;
    }

    /**
     * Set isRecommend
     *
     * @param boolean $isRecommend
     *
     * @return Category
     */
    public function setIsRecommend($isRecommend)
    {
        $this->isRecommend = $isRecommend;

        return $this;
    }

    /**
     * Get isRecommend
     *
     * @return boolean
     */
    public function getIsRecommend()
    {
        return $this->isRecommend;
    }
}

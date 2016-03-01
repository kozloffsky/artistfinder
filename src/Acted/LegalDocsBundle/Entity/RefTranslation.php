<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefTranslation
 */
class RefTranslation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $en;

    /**
     * @var string
     */
    private $fr;


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
     * Set en
     *
     * @param string $en
     *
     * @return RefTranslation
     */
    public function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set fr
     *
     * @param string $fr
     *
     * @return RefTranslation
     */
    public function setFr($fr)
    {
        $this->fr = $fr;

        return $this;
    }

    /**
     * Get fr
     *
     * @return string
     */
    public function getFr()
    {
        return $this->fr;
    }
}

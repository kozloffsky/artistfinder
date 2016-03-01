<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefTranslation
 */
class RefTranslation
{
    /**
     * @var int
     */
    private $id;


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
     * @var integer
     */
    private $translationId;

    /**
     * @var varchar
     */
    private $en;

    /**
     * @var varchar
     */
    private $fr;


    /**
     * Set translationId
     *
     * @param \integer $translationId
     *
     * @return RefTranslation
     */
    public function setTranslationId( $translationId)
    {
        $this->translationId = $translationId;

        return $this;
    }

    /**
     * Get translationId
     *
     * @return \integer
     */
    public function getTranslationId()
    {
        return $this->translationId;
    }

    /**
     * Set en
     *
     * @param \varchar $en
     *
     * @return RefTranslation
     */
    public function setEn(\varchar $en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return \varchar
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set fr
     *
     * @param \varchar $fr
     *
     * @return RefTranslation
     */
    public function setFr(\varchar $fr)
    {
        $this->fr = $fr;

        return $this;
    }

    /**
     * Get fr
     *
     * @return \varchar
     */
    public function getFr()
    {
        return $this->fr;
    }
}

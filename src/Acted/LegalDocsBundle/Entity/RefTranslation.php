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
     * @var mediumint
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
     * @param \mediumint $translationId
     *
     * @return RefTranslation
     */
    public function setTranslationId(\mediumint $translationId)
    {
        $this->translationId = $translationId;

        return $this;
    }

    /**
     * Get translationId
     *
     * @return \mediumint
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

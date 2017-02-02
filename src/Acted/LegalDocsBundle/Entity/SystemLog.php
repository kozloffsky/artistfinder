<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 1/14/17
 * Time: 15:47
 */

namespace Acted\LegalDocsBundle\Entity;


class SystemLog
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $logDate;

    /**
     * @var integer
     */
    private $targetUserId;

    /**
     * @var boolean
     */
    private $isReaded;


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
     * Set message
     *
     * @param string $message
     *
     * @return SystemLog
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set logDate
     *
     * @param \DateTime $logDate
     *
     * @return SystemLog
     */
    public function setLogDate($logDate)
    {
        $this->logDate = $logDate;

        return $this;
    }

    /**
     * Get logDate
     *
     * @return \DateTime
     */
    public function getLogDate()
    {
        return $this->logDate;
    }

    /**
     * Set targetUserId
     *
     * @param integer $targetUserId
     *
     * @return SystemLog
     */
    public function setTargetUserId($targetUserId)
    {
        $this->targetUserId = $targetUserId;

        return $this;
    }

    /**
     * Get targetUserId
     *
     * @return integer
     */
    public function getTargetUserId()
    {
        return $this->targetUserId;
    }

    /**
     * Set isReaded
     *
     * @param boolean $isReaded
     *
     * @return SystemLog
     */
    public function setIsReaded($isReaded)
    {
        $this->isReaded = $isReaded;

        return $this;
    }

    /**
     * Get isReaded
     *
     * @return boolean
     */
    public function getIsReaded()
    {
        return $this->isReaded;
    }
}

<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PaymentSetting
 */
class PaymentSetting
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $billingAddress;

    /**
     * @var string
     */
    private $accountName;

    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @var string
     */
    private $iban;

    /**
     * @var string
     */
    private $bankName ='';

    /**
     * @var string
     */
    private $swiftCode;

    /**
     * @var string
     */
    private $vatNumber;


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
     * Set userId
     *
     * @param integer $userId
     *
     * @return PaymentSetting
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @var string
     */
    private $oneToOne;

    /**
     * Get oneToOne
     *
     * @return string
     */
    public function getOneToOne()
    {
        return $this->oneToOne;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\User
     */
    private $user;

    /**
     * Set user
     *
     * @param \Acted\LegalDocsBundle\Entity\User $user
     *
     * @return PaymentSetting
     */
    public function setUser(\Acted\LegalDocsBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acted\LegalDocsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set billingAddress
     *
     * @param string $billingAddress
     *
     * @return PaymentSetting
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return string
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set accountName
     *
     * @param string $accountName
     *
     * @return PaymentSetting
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * Get accountName
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     *
     * @return PaymentSetting
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return integer
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set iban
     *
     * @param string $iban
     *
     * @return PaymentSetting
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     *
     * @return PaymentSetting
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set swiftCode
     *
     * @param string $swiftCode
     *
     * @return PaymentSetting
     */
    public function setSwiftCode($swiftCode)
    {
        $this->swiftCode = $swiftCode;

        return $this;
    }

    /**
     * Get swiftCode
     *
     * @return string
     */
    public function getSwiftCode()
    {
        return $this->swiftCode;
    }

    /**
     * Set vatNumber
     *
     * @param string $vatNumber
     *
     * @return PaymentSetting
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    /**
     * Get vatNumber
     *
     * @return string
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }
}

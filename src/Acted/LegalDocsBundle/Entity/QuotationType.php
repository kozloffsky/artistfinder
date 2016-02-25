<?php

namespace Acted\LegalDocsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuotationType
 *
 * @ORM\Table(name="QuotationType")
 * @ORM\Entity(repositoryClass="Acted\LegalDocsBundle\Repository\QuotationTypeRepository")
 */
class QuotationType
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
     * @ORM\Column(name="company_name", type="string", length=255)
     */
    private $company_name;

    /**
     * @var string
     *
     * @ORM\Column(name="artist_name", type="string", length=255)
     */
    private $artist_name;

    /**
     * @var string
     *
     * @ORM\Column(name="street_address", type="string", length=255)
     */
    private $street_address;
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_num", type="string", length=50)
     */
    private $phone_num;

    /**
     * @var string
     *
     * @ORM\Column(name="fax_num", type="string", length=50)
     */
    private $fax_num;
    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=50)
     */
    private $email_address;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name2", type="string", length=255)
     */
    private $company_name2;

    /**
     * @var string
     *
     * @ORM\Column(name="street_address2", type="string", length=255)
     */
    private $street_address2;

    /**
     * @var string
     *
     * @ORM\Column(name="city2", type="string", length=255)
     */
    private $city2;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode2", type="string", length=255)
     */
    private $zipcode2;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="timing", type="string", length=255)
     */
    private $timing;

    /**
     * @var string
     *
     * @ORM\Column(name="special_instructions", type="string", length=255)
     */
    private $special_instructions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="today_date", type="date")
     */
    private $today_date;

    /**
     * @var string
     *
     * @ORM\Column(name="quotation_id", type="string", length=255)
     */
    private $quotation_id;

    /**
     * @var string
     *
     * @ORM\Column(name="acted_id", type="string", length=255)
     */
    private $acted_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire_date", type="date")
     */
    private $expire_date;

    /**
     * @var string
     *
     * @ORM\Column(name="description_service1", type="string", length=255)
     */
    private $description_service1;

    /**
     * @var string
     *
     * @ORM\Column(name="description_service2", type="string", length=255)
     */
    private $description_service2;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_service1_taxed", type="boolean")
     */
    private $is_service1_taxed;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_service2_taxed", type="boolean")
     */
    private $is_service2_taxed;

    /**
     * @var string
     *
     * @ORM\Column(name="service1_amount", type="decimal", precision=9, scale=2)
     */
    private $service1_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="service2_amount", type="decimal", precision=9, scale=2)
     */
    private $service2_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_percent", type="decimal", precision=5, scale=2)
     */
    private $deposit_percent;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_amount", type="decimal", precision=9, scale=2)
     */
    private $deposit_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_percent", type="decimal", precision=5, scale=2)
     */
    private $balance_percent;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_amount", type="decimal", precision=9, scale=2)
     */
    private $balance_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_when", type="string", length=255)
     */
    private $balance_when;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_mode", type="string", length=255)
     */
    private $balance_mode;

    /**
     * @var string
     *
     * @ORM\Column(name="additional_comments", type="string", length=255)
     */
    private $additional_comments;

    /**
     * @var string
     *
     * @ORM\Column(name="subtotal_amount", type="decimal", precision=9, scale=2)
     */
    private $subtotal_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="taxable_amount", type="decimal", precision=9, scale=2)
     */
    private $taxable_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=5, scale=2)
     */
    private $tax_rate;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_amount", type="decimal", precision=9, scale=2)
     */
    private $tax_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="other_amount", type="decimal", precision=9, scale=2)
     */
    private $other_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=9, scale=2)
     */
    private $total_amount;

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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return QuotationType
     */
    public function setCompanyName($companyName)
    {
        $this->company_name = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set artistName
     *
     * @param string $artistName
     *
     * @return QuotationType
     */
    public function setArtistName($artistName)
    {
        $this->artist_name = $artistName;

        return $this;
    }

    /**
     * Get artistName
     *
     * @return string
     */
    public function getArtistName()
    {
        return $this->artist_name;
    }

    /**
     * Set streetAddress
     *
     * @param string $streetAddress
     *
     * @return QuotationType
     */
    public function setStreetAddress($streetAddress)
    {
        $this->street_address = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress
     *
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->street_address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return QuotationType
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return QuotationType
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set phoneNum
     *
     * @param string $phoneNum
     *
     * @return QuotationType
     */
    public function setPhoneNum($phoneNum)
    {
        $this->phone_num = $phoneNum;

        return $this;
    }

    /**
     * Get phoneNum
     *
     * @return string
     */
    public function getPhoneNum()
    {
        return $this->phone_num;
    }

    /**
     * Set faxNum
     *
     * @param string $faxNum
     *
     * @return QuotationType
     */
    public function setFaxNum($faxNum)
    {
        $this->fax_num = $faxNum;

        return $this;
    }

    /**
     * Get faxNum
     *
     * @return string
     */
    public function getFaxNum()
    {
        return $this->fax_num;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return QuotationType
     */
    public function setEmailAddress($emailAddress)
    {
        $this->email_address = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return QuotationType
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
     * Set companyName2
     *
     * @param string $companyName2
     *
     * @return QuotationType
     */
    public function setCompanyName2($companyName2)
    {
        $this->company_name2 = $companyName2;

        return $this;
    }

    /**
     * Get companyName2
     *
     * @return string
     */
    public function getCompanyName2()
    {
        return $this->company_name2;
    }

    /**
     * Set streetAddress2
     *
     * @param string $streetAddress2
     *
     * @return QuotationType
     */
    public function setStreetAddress2($streetAddress2)
    {
        $this->street_address2 = $streetAddress2;

        return $this;
    }

    /**
     * Get streetAddress2
     *
     * @return string
     */
    public function getStreetAddress2()
    {
        return $this->street_address2;
    }

    /**
     * Set city2
     *
     * @param string $city2
     *
     * @return QuotationType
     */
    public function setCity2($city2)
    {
        $this->city2 = $city2;

        return $this;
    }

    /**
     * Get city2
     *
     * @return string
     */
    public function getCity2()
    {
        return $this->city2;
    }

    /**
     * Set zipcode2
     *
     * @param string $zipcode2
     *
     * @return QuotationType
     */
    public function setZipcode2($zipcode2)
    {
        $this->zipcode2 = $zipcode2;

        return $this;
    }

    /**
     * Get zipcode2
     *
     * @return string
     */
    public function getZipcode2()
    {
        return $this->zipcode2;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return QuotationType
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return QuotationType
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set timing
     *
     * @param string $timing
     *
     * @return QuotationType
     */
    public function setTiming($timing)
    {
        $this->timing = $timing;

        return $this;
    }

    /**
     * Get timing
     *
     * @return string
     */
    public function getTiming()
    {
        return $this->timing;
    }

    /**
     * Set specialInstructions
     *
     * @param string $specialInstructions
     *
     * @return QuotationType
     */
    public function setSpecialInstructions($specialInstructions)
    {
        $this->special_instructions = $specialInstructions;

        return $this;
    }

    /**
     * Get specialInstructions
     *
     * @return string
     */
    public function getSpecialInstructions()
    {
        return $this->special_instructions;
    }

    /**
     * Set todayDate
     *
     * @param \DateTime $todayDate
     *
     * @return QuotationType
     */
    public function setTodayDate($todayDate)
    {
        $this->today_date = $todayDate;

        return $this;
    }

    /**
     * Get todayDate
     *
     * @return \DateTime
     */
    public function getTodayDate()
    {
        return $this->today_date;
    }

    /**
     * Set quotationId
     *
     * @param string $quotationId
     *
     * @return QuotationType
     */
    public function setQuotationId($quotationId)
    {
        $this->quotation_id = $quotationId;

        return $this;
    }

    /**
     * Get quotationId
     *
     * @return string
     */
    public function getQuotationId()
    {
        return $this->quotation_id;
    }

    /**
     * Set actedId
     *
     * @param string $actedId
     *
     * @return QuotationType
     */
    public function setActedId($actedId)
    {
        $this->acted_id = $actedId;

        return $this;
    }

    /**
     * Get actedId
     *
     * @return string
     */
    public function getActedId()
    {
        return $this->acted_id;
    }

    /**
     * Set expireDate
     *
     * @param \DateTime $expireDate
     *
     * @return QuotationType
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;

        return $this;
    }

    /**
     * Get expireDate
     *
     * @return \DateTime
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * Set descriptionService1
     *
     * @param string $descriptionService1
     *
     * @return QuotationType
     */
    public function setDescriptionService1($descriptionService1)
    {
        $this->description_service1 = $descriptionService1;

        return $this;
    }

    /**
     * Get descriptionService1
     *
     * @return string
     */
    public function getDescriptionService1()
    {
        return $this->description_service1;
    }

    /**
     * Set descriptionService2
     *
     * @param string $descriptionService2
     *
     * @return QuotationType
     */
    public function setDescriptionService2($descriptionService2)
    {
        $this->description_service2 = $descriptionService2;

        return $this;
    }

    /**
     * Get descriptionService2
     *
     * @return string
     */
    public function getDescriptionService2()
    {
        return $this->description_service2;
    }

    /**
     * Set isService1Taxed
     *
     * @param boolean $isService1Taxed
     *
     * @return QuotationType
     */
    public function setIsService1Taxed($isService1Taxed)
    {
        $this->is_service1_taxed = $isService1Taxed;

        return $this;
    }

    /**
     * Get isService1Taxed
     *
     * @return boolean
     */
    public function getIsService1Taxed()
    {
        return $this->is_service1_taxed;
    }

    /**
     * Set isService2Taxed
     *
     * @param boolean $isService2Taxed
     *
     * @return QuotationType
     */
    public function setIsService2Taxed($isService2Taxed)
    {
        $this->is_service2_taxed = $isService2Taxed;

        return $this;
    }

    /**
     * Get isService2Taxed
     *
     * @return boolean
     */
    public function getIsService2Taxed()
    {
        return $this->is_service2_taxed;
    }

    /**
     * Set service1Amount
     *
     * @param string $service1Amount
     *
     * @return QuotationType
     */
    public function setService1Amount($service1Amount)
    {
        $this->service1_amount = $service1Amount;

        return $this;
    }

    /**
     * Get service1Amount
     *
     * @return string
     */
    public function getService1Amount()
    {
        return $this->service1_amount;
    }

    /**
     * Set service2Amount
     *
     * @param string $service2Amount
     *
     * @return QuotationType
     */
    public function setService2Amount($service2Amount)
    {
        $this->service2_amount = $service2Amount;

        return $this;
    }

    /**
     * Get service2Amount
     *
     * @return string
     */
    public function getService2Amount()
    {
        return $this->service2_amount;
    }

    /**
     * Set depositPercent
     *
     * @param string $depositPercent
     *
     * @return QuotationType
     */
    public function setDepositPercent($depositPercent)
    {
        $this->deposit_percent = $depositPercent;

        return $this;
    }

    /**
     * Get depositPercent
     *
     * @return string
     */
    public function getDepositPercent()
    {
        return $this->deposit_percent;
    }

    /**
     * Set depositAmount
     *
     * @param string $depositAmount
     *
     * @return QuotationType
     */
    public function setDepositAmount($depositAmount)
    {
        $this->deposit_amount = $depositAmount;

        return $this;
    }

    /**
     * Get depositAmount
     *
     * @return string
     */
    public function getDepositAmount()
    {
        return $this->deposit_amount;
    }

    /**
     * Set balancePercent
     *
     * @param string $balancePercent
     *
     * @return QuotationType
     */
    public function setBalancePercent($balancePercent)
    {
        $this->balance_percent = $balancePercent;

        return $this;
    }

    /**
     * Get balancePercent
     *
     * @return string
     */
    public function getBalancePercent()
    {
        return $this->balance_percent;
    }

    /**
     * Set balanceAmount
     *
     * @param string $balanceAmount
     *
     * @return QuotationType
     */
    public function setBalanceAmount($balanceAmount)
    {
        $this->balance_amount = $balanceAmount;

        return $this;
    }

    /**
     * Get balanceAmount
     *
     * @return string
     */
    public function getBalanceAmount()
    {
        return $this->balance_amount;
    }

    /**
     * Set balanceWhen
     *
     * @param string $balanceWhen
     *
     * @return QuotationType
     */
    public function setBalanceWhen($balanceWhen)
    {
        $this->balance_when = $balanceWhen;

        return $this;
    }

    /**
     * Get balanceWhen
     *
     * @return string
     */
    public function getBalanceWhen()
    {
        return $this->balance_when;
    }

    /**
     * Set balanceMode
     *
     * @param string $balanceMode
     *
     * @return QuotationType
     */
    public function setBalanceMode($balanceMode)
    {
        $this->balance_mode = $balanceMode;

        return $this;
    }

    /**
     * Get balanceMode
     *
     * @return string
     */
    public function getBalanceMode()
    {
        return $this->balance_mode;
    }

    /**
     * Set additionalComments
     *
     * @param string $additionalComments
     *
     * @return QuotationType
     */
    public function setAdditionalComments($additionalComments)
    {
        $this->additional_comments = $additionalComments;

        return $this;
    }

    /**
     * Get additionalComments
     *
     * @return string
     */
    public function getAdditionalComments()
    {
        return $this->additional_comments;
    }

    /**
     * Set subtotalAmount
     *
     * @param string $subtotalAmount
     *
     * @return QuotationType
     */
    public function setSubtotalAmount($subtotalAmount)
    {
        $this->subtotal_amount = $subtotalAmount;

        return $this;
    }

    /**
     * Get subtotalAmount
     *
     * @return string
     */
    public function getSubtotalAmount()
    {
        return $this->subtotal_amount;
    }

    /**
     * Set taxableAmount
     *
     * @param string $taxableAmount
     *
     * @return QuotationType
     */
    public function setTaxableAmount($taxableAmount)
    {
        $this->taxable_amount = $taxableAmount;

        return $this;
    }

    /**
     * Get taxableAmount
     *
     * @return string
     */
    public function getTaxableAmount()
    {
        return $this->taxable_amount;
    }

    /**
     * Set taxRate
     *
     * @param string $taxRate
     *
     * @return QuotationType
     */
    public function setTaxRate($taxRate)
    {
        $this->tax_rate = $taxRate;

        return $this;
    }

    /**
     * Get taxRate
     *
     * @return string
     */
    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    /**
     * Set taxAmount
     *
     * @param string $taxAmount
     *
     * @return QuotationType
     */
    public function setTaxAmount($taxAmount)
    {
        $this->tax_amount = $taxAmount;

        return $this;
    }

    /**
     * Get taxAmount
     *
     * @return string
     */
    public function getTaxAmount()
    {
        return $this->tax_amount;
    }

    /**
     * Set otherAmount
     *
     * @param string $otherAmount
     *
     * @return QuotationType
     */
    public function setOtherAmount($otherAmount)
    {
        $this->other_amount = $otherAmount;

        return $this;
    }

    /**
     * Get otherAmount
     *
     * @return string
     */
    public function getOtherAmount()
    {
        return $this->other_amount;
    }

    /**
     * Set totalAmount
     *
     * @param string $totalAmount
     *
     * @return QuotationType
     */
    public function setTotalAmount($totalAmount)
    {
        $this->total_amount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }
}

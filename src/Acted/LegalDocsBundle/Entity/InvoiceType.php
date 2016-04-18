<?php

namespace Acted\LegalDocsBundle\Entity;

use Acted\LegalDocsBundle\Services\base\LegalDoc;
use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceType
 *
 * @ORM\Table(name="InvoiceType")
 * @ORM\Entity(repositoryClass="Acted\LegalDocsBundle\Repository\InvoiceTypeRepository")
 */
class InvoiceType implements LegalDoc
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
     * @var \DateTime
     *
     * @ORM\Column(name="today_date", type="date")
     */
    private $today_date;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_id", type="string", length=255)
     */
    private $invoice_id;

    /**
     * @var string
     *
     * @ORM\Column(name="acted_id", type="string", length=255)
     */
    private $acted_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="date")
     */
    private $due_date;

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
     * @var string
     *
     * @ORM\Column(name="service1_unitprice", type="decimal", precision=9, scale=2)
     */
    private $service1_unitprice;

    /**
     * @var string
     *
     * @ORM\Column(name="service2_unitprice", type="decimal", precision=9, scale=2)
     */
    private $service2_unitprice;

    /**
     * @var string
     *
     * @ORM\Column(name="service1_qty", type="integer")
     */
    private $service1_qty;

    /**
     * @var string
     *
     * @ORM\Column(name="service2_qty", type="integer")
     */
    private $service2_qty;

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
     * @var string
     *
     * @ORM\Column(name="acted_company_name", type="string", length=255)
     */
    private $acted_company_name;

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
     * @return InvoiceType
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
     * Set streetAddress
     *
     * @param string $streetAddress
     *
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * Set todayDate
     *
     * @param \DateTime $todayDate
     *
     * @return InvoiceType
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
     * Set invoiceId
     *
     * @param string $invoiceId
     *
     * @return InvoiceType
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoice_id = $invoiceId;

        return $this;
    }

    /**
     * Get invoiceId
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    /**
     * Set actedId
     *
     * @param string $actedId
     *
     * @return InvoiceType
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
     * Set dueDate
     *
     * @param \DateTime $dueDate
     *
     * @return InvoiceType
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * Set descriptionService1
     *
     * @param string $descriptionService1
     *
     * @return InvoiceType
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
     * @return InvoiceType
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
     * Set service1Unitprice
     *
     * @param string $service1Unitprice
     *
     * @return InvoiceType
     */
    public function setService1Unitprice($service1Unitprice)
    {
        $this->service1_unitprice = $service1Unitprice;

        return $this;
    }

    /**
     * Get service1Unitprice
     *
     * @return string
     */
    public function getService1Unitprice()
    {
        return $this->service1_unitprice;
    }

    /**
     * Set service2Unitprice
     *
     * @param string $service2Unitprice
     *
     * @return InvoiceType
     */
    public function setService2Unitprice($service2Unitprice)
    {
        $this->service2_unitprice = $service2Unitprice;

        return $this;
    }

    /**
     * Get service2Unitprice
     *
     * @return string
     */
    public function getService2Unitprice()
    {
        return $this->service2_unitprice;
    }

    /**
     * Set service1Qty
     *
     * @param integer $service1Qty
     *
     * @return InvoiceType
     */
    public function setService1Qty($service1Qty)
    {
        $this->service1_qty = $service1Qty;

        return $this;
    }

    /**
     * Get service1Qty
     *
     * @return integer
     */
    public function getService1Qty()
    {
        return $this->service1_qty;
    }

    /**
     * Set service2Qty
     *
     * @param integer $service2Qty
     *
     * @return InvoiceType
     */
    public function setService2Qty($service2Qty)
    {
        $this->service2_qty = $service2Qty;

        return $this;
    }

    /**
     * Get service2Qty
     *
     * @return integer
     */
    public function getService2Qty()
    {
        return $this->service2_qty;
    }

    /**
     * Set isService1Taxed
     *
     * @param boolean $isService1Taxed
     *
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * Set subtotalAmount
     *
     * @param string $subtotalAmount
     *
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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
     * @return InvoiceType
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

    /**
     * Set actedCompanyName
     *
     * @param string $actedCompanyName
     *
     * @return InvoiceType
     */
    public function setActedCompanyName($actedCompanyName)
    {
        $this->acted_company_name = $actedCompanyName;

        return $this;
    }

    /**
     * Get actedCompanyName
     *
     * @return string
     */
    public function getActedCompanyName()
    {
        return $this->acted_company_name;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\Event
     */
    private $event;


    /**
     * Set event
     *
     * @param \Acted\LegalDocsBundle\Entity\Event $event
     *
     * @return InvoiceType
     */
    public function setEvent(\Acted\LegalDocsBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Acted\LegalDocsBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
    /**
     * @var string
     */
    private $pdf_path;


    /**
     * Set pdfPath
     *
     * @param string $pdfPath
     *
     * @return InvoiceType
     */
    public function setPdfPath($pdfPath)
    {
        $this->pdf_path = $pdfPath;

        return $this;
    }

    /**
     * Get pdfPath
     *
     * @return string
     */
    public function getPdfPath()
    {
        return $this->pdf_path;
    }
}

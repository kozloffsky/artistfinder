<?php
/**
 * Class TemplatesService file
 *
 * @author Alex Makhorin
 */
namespace Acted\LegalDocsBundle\Services;

use Acted\LegalDocsBundle\Entity\Template;
/**
 * Class InvoiceService
 * @package Wmds\FrontBundle\Services
 * @author Alex Makhorin
 */
class QuotationTypeService extends base\TemplatesService
{

    /**
     * @var \Acted\LegalDocsBundle\Entity\QuotationType
     */
    protected $_data;

    protected function getTemplateId()
    {
        return Template::TYPE_QUOTATION;
    }

    public function company_name()
    {
        if (empty($this->_data->getCompanyName())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getCompanyName();
    }

    public function street_address()
    {
        if (empty($this->_data->getStreetAddress())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getStreetAddress();
    }

    public function city()
    {
        if (empty($this->_data->getCity())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getCity();
    }

    public function zipcode()
    {
        if (empty($this->_data->getZipcode())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getZipcode();
    }

    public function phone_num()
    {
        if (empty($this->_data->getPhoneNum())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getPhoneNum();
    }

    public function fax_num()
    {
        if (empty($this->_data->getFaxNum())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getFaxNum();
    }

    public function email_address()
    {
        if (empty($this->_data->getEmailAddress())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getEmailAddress();
    }

    public function name()
    {
        if (empty($this->_data->getName())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getName();
    }

    public function company_name2()
    {
        if (empty($this->_data->getCompanyName2())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getCompanyName2();
    }

    public function today_date()
    {
        if (empty($this->_data->getTodayDate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTodayDate()->format('Y-m-d');
    }

    public function street_address2()
    {
        if (empty($this->_data->getStreetAddress2())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getStreetAddress2();
    }

    public function city2()
    {
        if (empty($this->_data->getCity2())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getCity2();
    }

    public function zipcode2()
    {
        if (empty($this->_data->getZipcode2())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getZipcode2();
    }

    public function phone()
    {
        if (empty($this->_data->getPhone())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getPhone();
    }

    public function acted_id()
    {
        if (empty($this->_data->getActedId())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getActedId();
    }

    public function description_service1()
    {
        if (empty($this->_data->getDescriptionService1())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getDescriptionService1();
    }

    public function description_service2()
    {
        if (empty($this->_data->getDescriptionService2())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getDescriptionService2();
    }

    public function is_service1_taxed()
    {
        if (empty($this->_data->getIsService1Taxed())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getIsService1Taxed();
    }

    public function is_service2_taxed()
    {
        if (empty($this->_data->getIsService2Taxed())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getIsService2Taxed();
    }

    public function service1_amount()
    {
        if (empty($this->_data->getService1Amount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getService1Amount();
    }

    public function service2_amount()
    {
        if (empty($this->_data->getService2Amount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getService2Amount();
    }

    public function subtotal_amount()
    {
        if (empty($this->_data->getSubtotalAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getSubtotalAmount();
    }

    public function taxable_amount()
    {
        if (empty($this->_data->getTaxableAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTaxableAmount();
    }

    public function tax_rate()
    {
        if (empty($this->_data->getTaxRate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTaxRate();
    }

    public function tax_amount()
    {
        if (empty($this->_data->getTaxAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTaxAmount();
    }

    public function other_amount()
    {
        if (empty($this->_data->getOtherAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getOtherAmount();
    }

    public function total_amount()
    {
        if (empty($this->_data->getTotalAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTotalAmount();
    }

    public function artist_name()
    {
        if (empty($this->_data->getArtistName())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getArtistName();
    }

    public function expiry_date()
    {
        if (empty($this->_data->getExpireDate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getExpireDate()->format('Y-m-d');
    }

    public function quotation_id()
    {
        if (empty($this->_data->getQuotationId())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getQuotationId();
    }

    public function location()
    {
        if (empty($this->_data->getLocation())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getLocation();
    }

    public function timing()
    {
        if (empty($this->_data->getTiming())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTiming();
    }

    public function special_instructions()
    {
        if (empty($this->_data->getSpecialInstructions())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getSpecialInstructions();
    }

    public function deposit_percent()
    {
        if (empty($this->_data->getDepositPercent())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getDepositPercent();
    }

    public function deposit_amount()
    {
        if (empty($this->_data->getDepositAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getDepositAmount();
    }

    public function balance_percent()
    {
        if (empty($this->_data->getBalancePercent())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalancePercent();
    }

    public function balance_amount()
    {
        if (empty($this->_data->getBalanceAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalanceAmount();
    }

    public function balance_when()
    {
        if (empty($this->_data->getBalanceWhen())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalanceWhen();
    }

    public function balance_mode()
    {
        if (empty($this->_data->getBalanceMode())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalanceMode();
    }

    public function additional_comments()
    {
        if (empty($this->_data->getAdditionalComments())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getAdditionalComments();
    }

}
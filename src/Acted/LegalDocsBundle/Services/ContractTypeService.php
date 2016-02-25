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
class ContractTypeService extends base\TemplatesService
{
    protected function getTemplateId()
    {
        return Template::TYPE_PERFORMANCE_CONTRACT;
    }

    protected function getSavePath($fileName)
    {
        $path = $this->_container->get('kernel')->getRootDir();
        return realpath($path . '/../web/docs/performace_contract') . '/' . $fileName;
    }

    public function artist_address()
    {
        if (empty($this->_data->getArtistAddress())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getArtistAddress();
    }

    public function today_date()
    {
        if (empty($this->_data->getTodayDate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTodayDate()->format('Y-m-d');
    }

    public function artist_details()
    {
        if (empty($this->_data->getArtistDetails())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getArtistDetails();
    }

    public function client_details()
    {
        if (empty($this->_data->getClientDetails())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getClientDetails();
    }

    public function event_date()
    {
        if (empty($this->_data->getEventDate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getEventDate()->format('Y-m-d');
    }

    public function event_location()
    {
        if (empty($this->_data->getEventLocation())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getEventLocation();
    }

    public function performance_description()
    {
        if (empty($this->_data->getPerformanceDescription())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getPerformanceDescription();
    }

    public function event_amount()
    {
        if (empty($this->_data->getEventAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getEventAmount();
    }

    public function currency()
    {
        if (empty($this->_data->getCurrency())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getCurrency();
    }

    public function deposit_amount()
    {
        if (empty($this->_data->getDepositAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getDepositAmount();
    }

    public function deposit_percent()
    {
        if (empty($this->_data->getDepositPercent())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getDepositPercent();
    }

    public function balance_amount()
    {
        if (empty($this->_data->getBalanceAmount())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalanceAmount();
    }

    public function balance_percent()
    {
        if (empty($this->_data->getBalancePercent())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalancePercent();
    }

    public function balance_mode()
    {
        if (empty($this->_data->getBalanceMode())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalanceMode();
    }

    public function balance_when()
    {
        if (empty($this->_data->getBalanceWhen())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getBalanceWhen();
    }

    public function transportation()
    {
        if (empty($this->_data->getTransportation())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTransportation();
    }

    public function accomodation()
    {
        if (empty($this->_data->getAccomodation())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getAccomodation();
    }

    public function special_terms()
    {
        if (empty($this->_data->getSpecialTerms())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getSpecialTerms();
    }

    public function last_call_date()
    {
        if (empty($this->_data->getLastCallDate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getLastCallDate()->format('Y-m-d');
    }

    public function artist_name()
    {
        if (empty($this->_data->getArtistName())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getArtistName();
    }

    public function client_name()
    {
        if (empty($this->_data->getClientName())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getClientName();
    }
}
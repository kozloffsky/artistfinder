<?php
/**
 * Class TemplatesService file
 *
 * @author Alex Makhorin
 */
namespace Acted\LegalDocsBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Acted\LegalDocsBundle\Entity\PerformanceContract;
use Acted\LegalDocsBundle\Entity\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TFox\MpdfPortBundle\Service\MpdfService;

/**
 * Class InvoiceService
 * @package Wmds\FrontBundle\Services
 * @author Alex Makhorin
 */
class TemplatesService
{
    public $folder;
    public $_container;
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager|object
     */
    private $_em;

    /**
     * @var PerformanceContract
     */
    private $_data;

    /**
     * @var integer
     */
    private $_templateTypeId;

    /**
     * @var Template
     */
    private $_templateEntity;

    /**
     * @var string
     */
    private $_parsedTemplate;

    const SHORT_CODE_PATTERN = "/\[(.*?)\]/";

    /**
     * @param ContainerInterface $container
     * @param MpdfService $mpdf
     */
    public function __construct(ContainerInterface $container, MpdfService $mpdf)
    {
        $this->_container = $container;
        $this->_em = $container->get('doctrine')->getManager();
        $this->_mpdfService = $mpdf;
    }

    public function setData(PerformanceContract $data)
    {
        $this->_data = $data;
        return $this;
    }

    public function setTemplateId($id)
    {
        $this->_templateTypeId = $id;
        return $this;
    }

    /**
     * Parse and return parsed template as a string
     * @throws \Exception
     * @return string
     *
     * @author Alex Makhorin
     */
    public function getParsedTemplate()
    {
        if(empty($this->_data) || empty($this->_templateTypeId)) {
            throw new \Exception("You must set _data and _templateTypeId class variables. Use methods setData() and setTemplateId() in chain", 500);
        }

        $this->parse();
        return $this;
    }

    /**
     * GeneratePDF
     * @param integer $documentId
     * @return boolean
     *
     * @author Alex Makhorin
     */
    public function generatePdf($documentId)
    {
        $fileName = $documentId . '.pdf';

        return $this->_mpdfService->generatePdf($this->_parsedTemplate, [
            'outputFilename' => $this->getSavePath($fileName),
            'outputDest' => 'F',
        ]);
    }

    private function getSavePath($fileName)
    {
        $path = $this->_container->get('kernel')->getRootDir();
        return realpath($path . '/../web/docs/performace_contract') . '/' . $fileName;
    }

    /**
     * Method loads NotificationTemplateModel instance and parses template.
     * For internal use only.
     *
     * @author Alex Makhorin
     */
    protected function parse()
    {
        if($this->_templateEntity === null) {
            if ($this->_templateTypeId) {
                $this->_templateEntity = $this->_em->getRepository('ActedLegalDocsBundle:Template')->findOneBy([
                    'type_id' => $this->_templateTypeId,
                ]);
            }

            if (!$this->_templateEntity) {
                throw new \Exception('Template entity was not found. Probably _templateTypeId is not valid.', 500);
            }
        }

        $this->_parsedTemplate = preg_replace_callback(self::SHORT_CODE_PATTERN, array($this, 'replaceShortCodes'), $this->_templateEntity->getTemplate());
    }

    protected function replaceShortCodes($matches)
    {
        $methodName = strtolower($matches[1]);
        if (!method_exists($this, $methodName)) {
            throw new \Exception("You must implement a method for $matches[0] shortcode.", 500);
        }

        return $this->$methodName();
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

        //2016-02-07
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
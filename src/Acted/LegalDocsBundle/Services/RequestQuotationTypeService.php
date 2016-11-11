<?php
/**
 * Class TemplatesService file
 *
 * @author Alex Makhorin
 */
namespace Acted\LegalDocsBundle\Services;

use Acted\LegalDocsBundle\Entity\Template;
/**
 * Class RequestQuotationTypeService
 * @package Wmds\FrontBundle\Services
 * @author Sergey Gulidov
 */
class RequestQuotationTypeService extends base\TemplatesService
{

    /**
     * @var \Acted\LegalDocsBundle\Entity\QuotationType
     */
    protected $_data;

    protected function getTemplateId()
    {
        return Template::TYPE_REQUEST_QUOTATION;
    }

    public function artist_name()
    {
        if (empty($this->_data['artist_name'])) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data['artist_name'];
    }

    /*public function today_date()
    {
        if (empty($this->_data->getTodayDate())) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        return $this->_data->getTodayDate()->format('Y-m-d');
    }*/


    public function generateDocumentPdf($chatRoomId, $requestQuotationId)
    {
        $date = new \DateTime();
        $fileName = implode('_', ['Official_Quotation', $date->format('Ymd-His'), $chatRoomId, $requestQuotationId]);
        $fileName .= '.pdf';
        $documentDir = uniqid() . '/';

        $dir = dirname($this->getSavePath($fileName));

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }

        $this->_mpdfService->generatePdf($this->_parsedTemplate, [
            'outputFilename' => $dir.'/'.$fileName,
            'outputDest' => 'F',
        ]);

        return $this->dir.'/'.$fileName;
    }

}
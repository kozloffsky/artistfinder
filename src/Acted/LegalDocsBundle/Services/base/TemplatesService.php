<?php
/**
 * Class TemplatesService file
 *
 * @author Alex Makhorin
 */
namespace Acted\LegalDocsBundle\Services\base;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Acted\LegalDocsBundle\Entity\Template;
use TFox\MpdfPortBundle\Service\MpdfService;

/**
 * Class InvoiceService
 * @package Wmds\FrontBundle\Services
 * @author Alex Makhorin
 */
abstract class TemplatesService
{
    public $folder;

    public $_container;
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected $_em;

    protected $_data;

    /**
     * @var integer
     */
    protected $_templateTypeId;

    /**
     * @var Template
     */
    protected $_templateEntity;

    /**
     * @var string
     */
    protected $_parsedTemplate;

    const SHORT_CODE_PATTERN = "/\[(.*?)\]/";

    abstract protected function getTemplateId();

    abstract protected function getSavePath($fileName);

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

    public function setData($data)
    {
        $this->_data = $data;
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
        if(empty($this->_data) || empty($this->getTemplateId())) {
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

    /**
     * Method loads NotificationTemplateModel instance and parses template.
     * For internal use only.
     *
     * @author Alex Makhorin
     */
    protected function parse()
    {
        if($this->_templateEntity === null) {
            if ($this->getTemplateId()) {
                $this->_templateEntity = $this->_em->getRepository('ActedLegalDocsBundle:Template')->findOneBy([
                    'type_id' => $this->getTemplateId(),
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
}
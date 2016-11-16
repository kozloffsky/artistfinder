<?php

namespace Acted\LegalDocsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Template
 *
 * @ORM\Table(name="Template")
 * @ORM\Entity(repositoryClass="Acted\LegalDocsBundle\Repository\TemplateRepository")
 */
class Template
{
    const TYPE_PERFORMANCE_CONTRACT = '1';
    const TYPE_QUOTATION = '2';
    const TYPE_INVOICE = '3';
    const TYPE_REQUEST_QUOTATION = '4';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer")
     */
    private $type_id;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="text")
     */
    private $template;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $is_active;

    public static function listTypes()
    {
        return [
            self::TYPE_PERFORMANCE_CONTRACT => 'Performance Contract',
            self::TYPE_QUOTATION => 'Quotation',
            self::TYPE_INVOICE => 'Invoice',
            self::TYPE_REQUEST_QUOTATION => 'Request Quotation',
        ];
    }

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
     * Set template
     *
     * @param string $template
     * @return Template
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set is_active
     *
     * @param bool $isActive
     * @return Template
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set type_id
     *
     * @param integer $typeId
     * @return Template
     */
    public function setTypeId($typeId)
    {
        //TODO: check code
//        if (!in_array($typeId, self::listTypes())) {
//            throw new \InvalidArgumentException("Invalid status");
//        }

        $this->type_id = $typeId;

        return $this;
    }

    /**
     * Get type_id
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return self::listTypes()[$this->type_id];
    }
}

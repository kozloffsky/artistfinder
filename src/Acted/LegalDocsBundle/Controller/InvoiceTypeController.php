<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Acted\LegalDocsBundle\Entity\InvoiceType;
use Acted\LegalDocsBundle\Form\InvoiceTypeType;
use Acted\LegalDocsBundle\Entity\Template;

/**
 * InvoiceType controller.
 *
 */
class InvoiceTypeController extends Controller
{
    /**
     * Lists all InvoiceType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $invoiceTypes = $em->getRepository('ActedLegalDocsBundle:InvoiceType')->findAll();

        return $this->render('invoicetype/index.html.twig', array(
            'invoiceTypes' => $invoiceTypes,
        ));
    }

    /**
     * Creates a new InvoiceType entity.
     *
     */
    public function newAction(Request $request)
    {
        $invoiceType = new InvoiceType();
        $form = $this->createForm('Acted\LegalDocsBundle\Form\InvoiceTypeType', $invoiceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoiceType);
            $em->flush();

            $data = $form->getData();

            $pdfPath = $this->get('invoice_type')
                ->setData($data)
                ->getParsedTemplate()
                ->generatePdf($invoiceType);

            if ($pdfPath) {
                $invoiceType->setPdfPath($pdfPath);
                $em->flush();
            }

//            return $this->redirectToRoute('invoicetype_show', array('id' => $invoiceType->getId()));
            return $this->redirectToRoute('invoicetype_index');
        }

        return $this->render('invoicetype/new.html.twig', array(
            'invoiceType' => $invoiceType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InvoiceType entity.
     *
     */
    public function showAction(InvoiceType $invoiceType)
    {
        $deleteForm = $this->createDeleteForm($invoiceType);

        return $this->render('invoicetype/show.html.twig', array(
            'invoiceType' => $invoiceType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InvoiceType entity.
     *
     */
    public function editAction(Request $request, InvoiceType $invoiceType)
    {
        $deleteForm = $this->createDeleteForm($invoiceType);
        $editForm = $this->createForm('Acted\LegalDocsBundle\Form\InvoiceTypeType', $invoiceType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoiceType);
            $em->flush();

            $data = $editForm->getData();
            $this->get('invoice_type')
                ->setData($data)
                ->getParsedTemplate()
                ->generatePdf($invoiceType->getId());

            return $this->redirectToRoute('invoicetype_edit', array('id' => $invoiceType->getId()));
        }

        return $this->render('invoicetype/edit.html.twig', array(
            'invoiceType' => $invoiceType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InvoiceType entity.
     *
     */
    public function deleteAction(Request $request, InvoiceType $invoiceType)
    {
        $form = $this->createDeleteForm($invoiceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($invoiceType);
            $em->flush();
        }

        return $this->redirectToRoute('invoicetype_index');
    }

    /**
     * Creates a form to delete a InvoiceType entity.
     *
     * @param InvoiceType $invoiceType The InvoiceType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InvoiceType $invoiceType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('invoicetype_delete', array('id' => $invoiceType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

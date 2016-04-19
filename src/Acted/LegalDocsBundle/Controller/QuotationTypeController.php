<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acted\LegalDocsBundle\Entity\QuotationType;
use Acted\LegalDocsBundle\Form\QuotationTypeType;

/**
 * QuotationType controller.
 *
 */
class QuotationTypeController extends Controller
{
    /**
     * Lists all QuotationType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quotationTypes = $em->getRepository('ActedLegalDocsBundle:QuotationType')->findAll();

        return $this->render('quotationtype/index.html.twig', array(
            'quotationTypes' => $quotationTypes,
        ));
    }

    /**
     * Creates a new QuotationType entity.
     *
     */
    public function newAction(Request $request)
    {
        $quotationType = new QuotationType();
        $form = $this->createForm('Acted\LegalDocsBundle\Form\QuotationTypeType', $quotationType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quotationType);
            $em->flush();

            $data = $form->getData();

            $this->get('quotation_type')
                ->setData($data)
                ->getParsedTemplate()
                ->generatePdf($quotationType->getId());

//            return $this->redirectToRoute('quotationtype_show', array('id' => $quotationType->getId()));
            return $this->redirectToRoute('quotationtype_index');
        }

        return $this->render('quotationtype/new.html.twig', array(
            'quotationType' => $quotationType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a QuotationType entity.
     *
     */
    public function showAction(QuotationType $quotationType)
    {
        $deleteForm = $this->createDeleteForm($quotationType);

        return $this->render('quotationtype/show.html.twig', array(
            'quotationType' => $quotationType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing QuotationType entity.
     *
     */
    public function editAction(Request $request, QuotationType $quotationType)
    {
        $deleteForm = $this->createDeleteForm($quotationType);
        $editForm = $this->createForm('Acted\LegalDocsBundle\Form\QuotationTypeType', $quotationType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quotationType);
            $em->flush();

            $data = $editForm->getData();
            $this->get('quotation_type')
                ->setData($data)
                ->getParsedTemplate()
                ->generatePdf($quotationType->getId());

            return $this->redirectToRoute('quotationtype_edit', array('id' => $quotationType->getId()));
        }

        return $this->render('quotationtype/edit.html.twig', array(
            'quotationType' => $quotationType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a QuotationType entity.
     *
     */
    public function deleteAction(Request $request, QuotationType $quotationType)
    {
        $form = $this->createDeleteForm($quotationType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($quotationType);
            $em->flush();
        }

        return $this->redirectToRoute('quotationtype_index');
    }

    /**
     * Creates a form to delete a QuotationType entity.
     *
     * @param QuotationType $quotationType The QuotationType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(QuotationType $quotationType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('quotationtype_delete', array('id' => $quotationType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acted\LegalDocsBundle\Entity\PerformanceContract;
use Acted\LegalDocsBundle\Form\PerformanceContractType;

/**
 * PerformanceContract controller.
 *
 */
class PerformanceContractController extends Controller
{
    /**
     * Lists all PerformanceContract entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $performanceContracts = $em->getRepository('ActedLegalDocsBundle:PerformanceContract')->findAll();

        return $this->render('performancecontract/index.html.twig', array(
            'performanceContracts' => $performanceContracts,
        ));
    }

    /**
     * Creates a new PerformanceContract entity.
     *
     */
    public function newAction(Request $request)
    {
        $performanceContract = new PerformanceContract();
        $form = $this->createForm('Acted\LegalDocsBundle\Form\PerformanceContractType', $performanceContract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($performanceContract);
            $em->flush();

            $data = $form->getData();

            $this->get('templates')
                ->setTemplateId(Template::TYPE_PERFORMANCE_CONTRACT)
                ->setData($data)
                ->getParsedTemplate()
                ->generatePdf($performanceContract->getId());

            return $this->redirectToRoute('performancecontract_show', array('id' => $performanceContract->getId()));
        }

        return $this->render('performancecontract/new.html.twig', array(
            'performanceContract' => $performanceContract,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PerformanceContract entity.
     *
     */
    public function showAction(PerformanceContract $performanceContract)
    {
        $deleteForm = $this->createDeleteForm($performanceContract);

        return $this->render('performancecontract/show.html.twig', array(
            'performanceContract' => $performanceContract,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PerformanceContract entity.
     *
     */
    public function editAction(Request $request, PerformanceContract $performanceContract)
    {
        $deleteForm = $this->createDeleteForm($performanceContract);
        $editForm = $this->createForm('Acted\LegalDocsBundle\Form\PerformanceContractType', $performanceContract);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($performanceContract);
            $em->flush();

            return $this->redirectToRoute('performancecontract_edit', array('id' => $performanceContract->getId()));
        }

        return $this->render('performancecontract/edit.html.twig', array(
            'performanceContract' => $performanceContract,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PerformanceContract entity.
     *
     */
    public function deleteAction(Request $request, PerformanceContract $performanceContract)
    {
        $form = $this->createDeleteForm($performanceContract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($performanceContract);
            $em->flush();
        }

        return $this->redirectToRoute('performancecontract_index');
    }

    /**
     * Creates a form to delete a PerformanceContract entity.
     *
     * @param PerformanceContract $performanceContract The PerformanceContract entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PerformanceContract $performanceContract)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('performancecontract_delete', array('id' => $performanceContract->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

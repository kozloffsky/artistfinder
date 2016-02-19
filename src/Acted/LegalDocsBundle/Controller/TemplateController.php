<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acted\LegalDocsBundle\Entity\Template;
use Acted\LegalDocsBundle\Form\TemplateType;

/**
 * Template controller.
 *
 */
class TemplateController extends Controller
{
    /**
     * Lists all Template entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $templates = $em->getRepository('ActedLegalDocsBundle:Template')->findAll();

        return $this->render('template/index.html.twig', array(
            'templates' => $templates,
        ));
    }

    /**
     * Creates a new Template entity.
     *
     */
    public function newAction(Request $request)
    {
        $template = new Template();
        $form = $this->createForm('Acted\LegalDocsBundle\Form\TemplateType', $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            return $this->redirectToRoute('template_show', array('id' => $template->getId()));
        }

        return $this->render('template/new.html.twig', array(
            'template' => $template,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Template entity.
     *
     */
    public function showAction(Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);

        return $this->render('template/show.html.twig', array(
            'template' => $template,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Template entity.
     *
     */
    public function editAction(Request $request, Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);
        $editForm = $this->createForm('Acted\LegalDocsBundle\Form\TemplateType', $template);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            return $this->redirectToRoute('template_edit', array('id' => $template->getId()));
        }

        return $this->render('template/edit.html.twig', array(
            'template' => $template,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Template entity.
     *
     */
    public function deleteAction(Request $request, Template $template)
    {
        $form = $this->createDeleteForm($template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($template);
            $em->flush();
        }

        return $this->redirectToRoute('template_index');
    }

    /**
     * Creates a form to delete a Template entity.
     *
     * @param Template $template The Template entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Template $template)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('template_delete', array('id' => $template->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

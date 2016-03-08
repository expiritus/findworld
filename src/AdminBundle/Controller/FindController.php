<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Find;
use AdminBundle\Form\FindType;

/**
 * Find controller.
 *
 * @Route("/admin/find")
 */
class FindController extends Controller
{
    /**
     * Lists all Find entities.
     *
     * @Route("/", name="admin_find_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $finds = $em->getRepository('AdminBundle:Find')->findAll();

        return $this->render('AdminBundle:find/index.html.twig', array(
            'finds' => $finds,
        ));
    }

    /**
     * Creates a new Find entity.
     *
     * @Route("/new", name="admin_find_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $find = new Find();
        $form = $this->createForm('AdminBundle\Form\FindType', $find);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($find);
            $em->flush();

            return $this->redirectToRoute('admin_find_show', array('id' => $find->getId()));
        }

        return $this->render('AdminBundle:find/new.html.twig', array(
            'find' => $find,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Find entity.
     *
     * @Route("/{id}", name="admin_find_show")
     * @Method("GET")
     */
    public function showAction(Find $find)
    {
        $deleteForm = $this->createDeleteForm($find);

        return $this->render('AdminBundle:find/show.html.twig', array(
            'find' => $find,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Find entity.
     *
     * @Route("/{id}/edit", name="admin_find_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Find $find)
    {
        $deleteForm = $this->createDeleteForm($find);
        $editForm = $this->createForm('AdminBundle\Form\FindType', $find);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($find);
            $em->flush();

            return $this->redirectToRoute('admin_find_edit', array('id' => $find->getId()));
        }

        return $this->render('AdminBundle:find/edit.html.twig', array(
            'find' => $find,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Find entity.
     *
     * @Route("/{id}", name="admin_find_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Find $find)
    {
        $form = $this->createDeleteForm($find);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($find);
            $em->flush();
        }

        return $this->redirectToRoute('admin_find_index');
    }

    /**
     * Creates a form to delete a Find entity.
     *
     * @param Find $find The Find entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Find $find)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_find_delete', array('id' => $find->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

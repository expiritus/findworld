<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Thing;
use AdminBundle\Form\ThingType;

/**
 * Thing controller.
 *
 * @Route("/admin/thing")
 */
class ThingController extends Controller
{
    /**
     * Lists all Thing entities.
     *
     * @Route("/", name="admin_thing_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $things = $em->getRepository('AdminBundle:Thing')->findAll();

        return $this->render('AdminBundle:thing/index.html.twig', array(
            'things' => $things,
        ));
    }

    /**
     * Creates a new Thing entity.
     *
     * @Route("/new", name="admin_thing_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $thing = new Thing();
        $form = $this->createForm('AdminBundle\Form\ThingType', $thing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($thing);
            $em->flush();

            return $this->redirectToRoute('admin_thing_show', array('id' => $thing->getId()));
        }

        return $this->render('AdminBundle:thing/new.html.twig', array(
            'thing' => $thing,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Thing entity.
     *
     * @Route("/{id}", name="admin_thing_show")
     * @Method("GET")
     */
    public function showAction(Thing $thing)
    {
        $deleteForm = $this->createDeleteForm($thing);

        return $this->render('AdminBundle:thing/show.html.twig', array(
            'thing' => $thing,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Thing entity.
     *
     * @Route("/{id}/edit", name="admin_thing_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Thing $thing)
    {
        $deleteForm = $this->createDeleteForm($thing);
        $editForm = $this->createForm('AdminBundle\Form\ThingType', $thing);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($thing);
            $em->flush();

            return $this->redirectToRoute('admin_thing_edit', array('id' => $thing->getId()));
        }

        return $this->render('AdminBundle:thing/edit.html.twig', array(
            'thing' => $thing,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Thing entity.
     *
     * @Route("/{id}", name="admin_thing_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Thing $thing)
    {
        $form = $this->createDeleteForm($thing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($thing);
            $em->flush();
        }

        return $this->redirectToRoute('admin_thing_index');
    }

    /**
     * Creates a form to delete a Thing entity.
     *
     * @param Thing $thing The Thing entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Thing $thing)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_thing_delete', array('id' => $thing->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

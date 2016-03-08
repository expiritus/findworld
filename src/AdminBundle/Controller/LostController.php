<?php

namespace AdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Lost;
use AdminBundle\Form\LostType;

/**
 * Lost controller.
 *
 * @Route("/admin/lost")
 */
class LostController extends Controller
{
    /**
     * Lists all Lost entities.
     *
     * @Route("/", name="admin_lost_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $losts = $em->getRepository('AdminBundle:Lost')->findAll();

        return $this->render('AdminBundle:lost/index.html.twig', array(
            'losts' => $losts,
        ));
    }

    /**
     * Creates a new Lost entity.
     *
     * @Route("/new", name="admin_lost_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lost = new Lost();
        $form = $this->createForm('AdminBundle\Form\LostType', $lost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lost);
            $em->flush();

            return $this->redirectToRoute('admin_lost_show', array('id' => $lost->getId()));
        }

        return $this->render('AdminBundle:lost/new.html.twig', array(
            'lost' => $lost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lost entity.
     *
     * @Route("/{id}", name="admin_lost_show")
     * @Method("GET")
     */
    public function showAction(Lost $lost)
    {
        $deleteForm = $this->createDeleteForm($lost);

        return $this->render('AdminBundle:lost/show.html.twig', array(
            'lost' => $lost,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lost entity.
     *
     * @Route("/{id}/edit", name="admin_lost_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lost $lost)
    {
        $deleteForm = $this->createDeleteForm($lost);
        $editForm = $this->createForm('AdminBundle\Form\LostType', $lost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lost);
            $em->flush();

            return $this->redirectToRoute('admin_lost_edit', array('id' => $lost->getId()));
        }

        return $this->render('AdminBundle:lost/edit.html.twig', array(
            'lost' => $lost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lost entity.
     *
     * @Route("/{id}", name="admin_lost_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lost $lost)
    {
        $form = $this->createDeleteForm($lost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lost);
            $em->flush();
        }

        return $this->redirectToRoute('admin_lost_index');
    }

    /**
     * Creates a form to delete a Lost entity.
     *
     * @param Lost $lost The Lost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lost $lost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_lost_delete', array('id' => $lost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

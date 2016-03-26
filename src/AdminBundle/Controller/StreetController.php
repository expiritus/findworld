<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Street;
use AdminBundle\Form\StreetType;

/**
 * Street controller.
 *
 * @Route("/admin/street")
 */
class StreetController extends Controller
{
    /**
     * Lists all Street entities.
     *
     * @Route("/", name="admin_street_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $streets = $em->getRepository('AdminBundle:Street')->findAll();

        return $this->render('AdminBundle:street/index.html.twig', array(
            'streets' => $streets,
        ));
    }

    /**
     * Creates a new Street entity.
     *
     * @Route("/new", name="admin_street_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $street = new Street();
        $form = $this->createForm('AdminBundle\Form\StreetType', $street);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($street);
            $em->flush();

            return $this->redirectToRoute('admin_street_show', array('id' => $street->getId()));
        }

        return $this->render('AdminBundle:street/new.html.twig', array(
            'street' => $street,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Street entity.
     *
     * @Route("/{id}", name="admin_street_show")
     * @Method("GET")
     */
    public function showAction(Street $street)
    {
        $deleteForm = $this->createDeleteForm($street);

        return $this->render('AdminBundle:street/show.html.twig', array(
            'street' => $street,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Street entity.
     *
     * @Route("/{id}/edit", name="admin_street_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Street $street)
    {
        $deleteForm = $this->createDeleteForm($street);
        $editForm = $this->createForm('AdminBundle\Form\StreetType', $street);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($street);
            $em->flush();

            return $this->redirectToRoute('admin_street_edit', array('id' => $street->getId()));
        }

        return $this->render('AdminBundle:street/edit.html.twig', array(
            'street' => $street,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Street entity.
     *
     * @Route("/{id}", name="admin_street_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Street $street)
    {
        $form = $this->createDeleteForm($street);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($street);
            $em->flush();
        }

        return $this->redirectToRoute('admin_street_index');
    }

    /**
     * Creates a form to delete a Street entity.
     *
     * @param Street $street The Street entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Street $street)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_street_delete', array('id' => $street->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conveyance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conveyance controller.
 *
 * @Route("conveyance")
 */
class ConveyanceController extends Controller
{
    /**
     * Lists all conveyance entities.
     *
     * @Route("/", name="conveyance_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conveyances = $em->getRepository('AppBundle:Conveyance')->findAll();

        return $this->render('conveyance/index.html.twig', array(
            'conveyances' => $conveyances,
        ));
    }

    /**
     * Creates a new conveyance entity.
     *
     * @Route("/new", name="conveyance_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $conveyance = new Conveyance();
        $form = $this->createForm('AppBundle\Form\ConveyanceType', $conveyance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conveyance);
            $em->flush();

            return $this->redirectToRoute('conveyance_show', array('id' => $conveyance->getId()));
        }

        return $this->render('conveyance/new.html.twig', array(
            'conveyance' => $conveyance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conveyance entity.
     *
     * @Route("/{id}", name="conveyance_show")
     * @Method("GET")
     */
    public function showAction(Conveyance $conveyance)
    {
        $deleteForm = $this->createDeleteForm($conveyance);

        return $this->render('conveyance/show.html.twig', array(
            'conveyance' => $conveyance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conveyance entity.
     *
     * @Route("/{id}/edit", name="conveyance_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Conveyance $conveyance)
    {
        $deleteForm = $this->createDeleteForm($conveyance);
        $editForm = $this->createForm('AppBundle\Form\ConveyanceType', $conveyance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conveyance_edit', array('id' => $conveyance->getId()));
        }

        return $this->render('conveyance/edit.html.twig', array(
            'conveyance' => $conveyance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conveyance entity.
     *
     * @Route("/{id}", name="conveyance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Conveyance $conveyance)
    {
        $form = $this->createDeleteForm($conveyance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conveyance);
            $em->flush();
        }

        return $this->redirectToRoute('conveyance_index');
    }

    /**
     * Creates a form to delete a conveyance entity.
     *
     * @param Conveyance $conveyance The conveyance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Conveyance $conveyance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conveyance_delete', array('id' => $conveyance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Products_Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Products_category controller.
 *
 * @Route("products_category")
 */
class Products_CategoryController extends Controller
{
    /**
     * Lists all products_Category entities.
     *
     * @Route("/", name="products_category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products_Categories = $em->getRepository('AppBundle:Products_Category')->findAll();

        return $this->render('products_category/index.html.twig', array(
            'products_Categories' => $products_Categories,
        ));
    }

    /**
     * Creates a new products_Category entity.
     *
     * @Route("/new", name="products_category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $products_Category = new Products_category();
        $form = $this->createForm('AppBundle\Form\Products_CategoryType', $products_Category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($products_Category);
            $em->flush();

            return $this->redirectToRoute('products_category_show', array('id' => $products_Category->getId()));
        }

        return $this->render('products_category/new.html.twig', array(
            'products_Category' => $products_Category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a products_Category entity.
     *
     * @Route("/{id}", name="products_category_show")
     * @Method("GET")
     */
    public function showAction(Products_Category $products_Category)
    {
        $deleteForm = $this->createDeleteForm($products_Category);

        return $this->render('products_category/show.html.twig', array(
            'products_Category' => $products_Category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing products_Category entity.
     *
     * @Route("/{id}/edit", name="products_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Products_Category $products_Category)
    {
        $deleteForm = $this->createDeleteForm($products_Category);
        $editForm = $this->createForm('AppBundle\Form\Products_CategoryType', $products_Category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('products_category_edit', array('id' => $products_Category->getId()));
        }

        return $this->render('products_category/edit.html.twig', array(
            'products_Category' => $products_Category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a products_Category entity.
     *
     * @Route("/{id}", name="products_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Products_Category $products_Category)
    {
        $form = $this->createDeleteForm($products_Category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($products_Category);
            $em->flush();
        }

        return $this->redirectToRoute('products_category_index');
    }

    /**
     * Creates a form to delete a products_Category entity.
     *
     * @param Products_Category $products_Category The products_Category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Products_Category $products_Category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('products_category_delete', array('id' => $products_Category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

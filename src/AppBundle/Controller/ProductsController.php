<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Products;
use AppBundle\Entity\Products_Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("products")
 */
class ProductsController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="products_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->findAll();

        return $this->render('products/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="products_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Products();
        $form = $this->createForm('AppBundle\Form\ProductsType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('products_show', array('id' => $product->getId()));
        }

        return $this->render('products/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="products_show")
     * @Method("GET")
     */
    public function showAction(Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('products/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="products_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductsType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('products_edit', array('id' => $product->getId()));
        }

        return $this->render('products/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="products_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Products $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('products_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Products $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Products $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('products_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/list/ajax", name="products_show_ajax")
     * @Method("GET")
     */

    public function getProductsAjax(Request $request)
    {
    
        ini_set('max_execution_time',0);

        $f_i = $request->query->get('fecha_i');
        $f_f = $request->query->get('fecha_f');
    
        $sEcho = $request->query->get('draw');
        $iDisplayStart = $request->query->get('start');
        $iDisplayLength = $request->query->get('length');

        //Ordering
        $iSortCol_0 = $request->query->get('iSortCol_0');
        $iSortingCols = $request->query->get('iSortingCols');
        $aColumns = array("p.id", "p.code", "p.name", "p.description", "p.mark", "p.price", "c.nameCat");
        
        //List products whith categorys active
        $sWhere = 'WHERE c.active=1 ';
        //Order predetermined
        $OrderD = 'ASC';

        //Searching
        $sSearch = $request->query->get('search')['value'];
        $OrderD = $request->query->get('order')[0]['dir'];

        //Ordering
        $sByColumn = $request->query->get('order')[0]['column'];


        //Order according to colum
        $bY = "p.id";
        if($sByColumn == 0){

            $bY="p.id";

        }elseif($sByColumn == 1){

            $bY="p.code";

        }elseif($sByColumn == 2){

            $bY="p.name";

        }elseif($sByColumn == 3){

            $bY="p.description";

        }elseif($sByColumn == 4){

            $bY="p.mark";

        }elseif($sByColumn == 5){

            $bY="p.price";
        }elseif($sByColumn == 6){

            $bY="c.nameCat";
        }         
        
        //Validate search input
        if ($sSearch != null && $sSearch != "")
        {
            if ($sWhere == '') {
                $sWhere .= 'WHERE (';
            } else {
                $sWhere .= 'AND (';
            }
            //concat colums of entity
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . ' LIKE \'%' . $sSearch . '%\' OR ';
            }

            $sWhere = substr_replace($sWhere, '', -4);
            $sWhere .= ')';
        }

        //Query for list with limit
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            "SELECT p.id, p.code, p.name, p.description, p.mark, p.price, c.nameCat
            FROM AppBundle:Products p 
            JOIN p.products_Category c "
            . $sWhere  
            ." ORDER BY "
            . $bY . " " . $OrderD
        );

        $inventario = $query->setMaxResults($iDisplayLength)
                            ->setFirstResult($iDisplayStart)
                            ->getResult();

        //var_dump($inventario); exit();

        //data total in DB
        $query = $em->createQuery(
            "SELECT p.id, p.code, p.name, p.description, p.mark, p.price, c.nameCat
            FROM AppBundle:Products p 
            JOIN p.products_Category c "
            . $sWhere . 
            " ORDER BY "
            . $bY . " " . $OrderD
        );

        $inventario2 = $query->getResult();

        //count for list
        $filteredInventario = count($inventario);
        $totalInventario    = count($inventario2);

        $output = array(
            "draw"            => $sEcho,
            "recordsTotal"    => $filteredInventario,
            "recordsFiltered" => $totalInventario,
            "data"            => array(),
        );
        
        //building array for table
        foreach ($inventario as $inv)
        {
            //buttons for edit and view products
            $options    =   '<a class="btn btn-success" 
                            href="/products/'.$inv['id'].'/edit">
                                <i class="fa fa-edit"></i> Edit</a>'
                            .' <a class="btn btn-success" href="/products/'.$inv['id'].'">
                            <i class="fa fa-edit"></i> Ver</a>';

            $row = array();          

            $row[] = $inv['id'];
            $row[] = $inv['code'];
            $row[] = $inv['name'];
            $row[] = $inv['description'];
            $row[] = $inv['mark'];
            $row[] = $inv['nameCat'];
            $row[] = $inv['price'];
            $row[] = $options;

            $output['data'][] = $row;

        }

        return $this->json($output);
    }
}

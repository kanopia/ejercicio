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

            //return $this->redirectToRoute('products_category_edit', array('id' => $products_Category->getId()));
            return $this->redirectToRoute('products_category_index');

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

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/valCategory/ajax", name="val_category")
     * @Method("GET")
     */
    public function validateCategoryAjax(Request $request){

        $resCode = 0;
        $resName = 0;

        if ($request->isXmlHttpRequest()) {

            $codeCat = $request->query->get('codeCat');
            $nameCat = $request->query->get('nameCat');

            if (!empty($codeCat)) {

                $prodCode = $this->getDoctrine()
                ->getRepository(Products_Category::class)
                ->findOneByCode($codeCat);

                if (!$prodCode) {
                    $resCode = 0;
                }else{
                    $resCode = 1;
                }
            }

            if (!empty($nameCat)) {

                $prodName = $this->getDoctrine()
                ->getRepository(Products_Category::class)
                ->findOneByNameCat($nameCat);

                if (!$prodName) {
                    $resName = 0;
                }else{
                    $resName = 1;
                }
            }

        }
        return $this->json(array('resCode' => $resCode , 'resName' => $resName));
    }  

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/list/cat/ajax", name="categorias_show_ajax")
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
        $aColumns = array("c.id", "c.code", "c.nameCat", "c.description", "c.active");
        
        //Where empty
        $sWhere = '';
        //Order predetermined
        $OrderD = 'ASC';

        //Searching
        $sSearch = $request->query->get('search')['value'];        
        $OrderD = $request->query->get('order')[0]['dir'];

        //Ordering
        $sByColumn = $request->query->get('order')[0]['column'];

        //Order according to colum
        $bY = "c.id";
        if($sByColumn == 0){

            $bY="c.id";

        }elseif($sByColumn == 1){

            $bY="c.code";

        }elseif($sByColumn == 2){

            $bY="c.nameCat";

        }elseif($sByColumn == 3){

            $bY="c.description";

        }elseif($sByColumn == 4){

            $bY="c.active";

        }       
        
        //Validate search input
        if ($sSearch != null && $sSearch != "")
        {
            if ($sWhere == '') {
                $sWhere .= 'WHERE (';
            } else {
                $sWhere .= ' AND (';
            }
            //concat colums of entity
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . ' LIKE \'%' . $sSearch . '%\' OR ';
            }

            $sWhere = substr_replace($sWhere, '', -4);
            $sWhere .= ') ';


        }

        //Query for list with limit
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            "SELECT c.id, c.code, c.nameCat, c.description, c.active
            FROM AppBundle:Products_Category c "
            . $sWhere . 
            " ORDER BY "
            . $bY . " " . $OrderD
        );

        $inventario = $query->setMaxResults($iDisplayLength)
                            ->setFirstResult($iDisplayStart)
                            ->getResult();


        $query = $em->createQuery(
            "SELECT c.id, c.code, c.nameCat, c.description, c.active
            FROM AppBundle:Products_Category c "
            . $sWhere . 
            " ORDER BY "
            . $bY . " " . $OrderD
        );

        //data total in DB
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
                            href="/products_category/'.$inv['id'].'/edit">
                                <i class="fa fa-edit"></i> Edit</a>'
                            .' <a class="btn btn-success" href="/products_category/'.$inv['id'].'">
                            <i class="fa fa-edit"></i> Ver</a>';

            $active = '';
            if ($inv['active']) {
                $active = 'Sí';
            }else{
                $active = 'No';
            }

            $row = array();          

            $row[] = $inv['id'];
            $row[] = $inv['code'];
            $row[] = $inv['nameCat'];
            $row[] = $inv['description'];
            $row[] = $active;
            $row[] = $options;

            $output['data'][] = $row;

        }

        return $this->json($output);
    }
}

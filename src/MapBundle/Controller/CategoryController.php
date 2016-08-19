<?php

namespace MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MapBundle\Controller\DefaultController;
use MapBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends DefaultController
{
    
/**
 * @Route("/category/add")
 *
 */
    
    public function addCategoryAction(){ //kategorie dodajemy na sztywno, wiec nie potrzeba budowac formularza do tego celu
        
        $dataBases = new Category();
        $dataBases->setName("Geograficzne bazy danych");
        $dataBases->setCategoryDescription("Dane w formie geograficznych baz danych. Doppuszczalne rozszerzenia plików: .mdb, .gdb");
        
        $rasters = new Category();
        $rasters->setName("Mapy w formatach rastrowych");
        $rasters->setCategoryDescription("Zdigitalizowane materiały analogowe, produkty wygenerowane w formiatach rastrowych. Dopuszczalne rozszerzenia plików: .tiff, .png, .jpg");
        
        $shapes = new Category();
        $shapes->setName("Dane w formacie shp");
        $shapes->setCategoryDescription("Wszelkie dane geograficzne w formacie .shp");
        
        $this->em()->persist($dataBases);
        $this->em()->persist($rasters);
        $this->em()->persist($shapes);
        $this->em()->flush();
        
        return new Response("Added classes");

    }
    
    /**
     * @Route("/category/edit/{id}")
     * @Template("MapBundle:Map:showForm.html.twig")
     * @Method({"GET"})
     * 
     */
    
    public function editCategoryAction($id){
        
        $catRepo = $this->getDoctrine()->getRepository("MapBundle:Category");
        $category = $catRepo->find($id);
        $form = $this->createCategoryForm($category);
    
        return ["form" => $form->createView()];
  
    }
    
    /**
     * @Route("/category/edit/{id}")

     * @Method({"POST"})
     */
    
    public function setEditedCategoryDataAction(Request $req, $id){
        
        $catRepo = $this->getDoctrine()->getRepository("MapBundle:Category");
        $category = $catRepo->find($id);
        $form = $this->createCategoryForm($category);
        $form->handleRequest($req);
        
        $this->em()->flush();
        
        return new Response();

    }
    
    /**
     * @Route("/category/showAll")
     * @Template("MapBundle:Map:showAll.html.twig")
     * 
     */
    
    public function showAllCategoriesAction(){
        
        $catRepo = $this->getDoctrine()->getRepository("MapBundle:Category");
        $allCategories = $catRepo->findAll();
        
        return ['allCategories' => $allCategories];
    }
    
    
    /**
     * @Route("/category/delete/{id}")
     */
    public function deleteCategory($id){
        
        $catRepo = $this->getDoctrine()->getRepository("MapBundle:Category");
        $category = $catRepo->find($id);
        
        $this->em()->remove($category);
        $this->em()->flush();
        
        return $this->redirectToRoute('map_category_showallcategories');
    }
    


    private function createCategoryForm(Category $category){
        return $this->createFormBuilder($category)
                ->add("name", "textarea", ["label" => "Nazwa: "])
                ->add("categoryDescription", "textarea", ["label" => "Opis: "])
                ->add("send", "submit")
                ->getForm();
        
    }

    
}

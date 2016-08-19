<?php

namespace MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MapBundle\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends DefaultController
{
    
    /**
     * @Route("/type/add")
     * @Template("MapBundle:Map:showForm.html.twig")
     * @Method({"GET"})
     */
    
    public function addTypeAction(){
        
        $newType = new Type();
        $form = $this->createTypeForm($newType);
        
        return ["form" => $form->createView()];
    }
    
    /**
     * @Route("/type/add")
     * @Method({"POST"})
     */
    
    public function getNewTypeDataAction(Request $req){
        
        $newType = new Type();
        $form = $this->createTypeForm($newType);
        $form->handleRequest($req);
        
        $this->em()->persist($newType);
        $this->em()->flush();
        
        return new Response("Dodano nowy typ");
        
    }
    
    /**
     * @Route("/type/edit/{id}")
     * @Template("MapBundle:Map:showForm.html.twig")
     * @Method({"GET"})
     */
    
    public function editTypeDataAction($id){
        
        $typeRepo = $this->getDoctrine()->getRepository("MapBundle:Type");
        $type = $typeRepo->find($id);
        $form = $this->createTypeForm($type);
        
        return ["form" => $form->createView()];
        
    }
    
    /**
     * @Route("/type/edit/{id}")
     * @Template("base.html.twig")
     * @Method({"POST"})
     */
    
    public function getEditedTypeData(Request $req, $id){
        
        $typeRepo = $this->getDoctrine()->getRepository("MapBundle:Type");
        $type = $typeRepo->find($id);
        $form = $this->createTypeForm($type);
        $form->handleRequest($req);
        
        $this->em()->flush();
        
    }
    
    /**
     * @Route("/type/delete/{id}")
     * @Template("base.html.twig")
     */
    public function deleteTypeAction($id){
        
        $typeRepo = $this->getDoctrine()->getRepository("MapBundle:Type");
        $type = $typeRepo->find($id);
        
        $this->em()->remove($type);
        $this->em()->flush();
    
    }
    
    private function createTypeForm(Type $type){
        return $this->createFormBuilder($type)
                ->add("name", "text", ["label" => "Nazwa: "])
                ->add("send", "submit")
                ->getForm();
    }
    
    

    
    
}

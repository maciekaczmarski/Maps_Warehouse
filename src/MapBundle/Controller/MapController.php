<?php

namespace MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MapBundle\Entity\Map;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class MapController extends DefaultController
{
    /**
     * @Route("/map/add")
     * @Template("MapBundle:Map:showForm.html.twig")
     * @Method({"GET"})
     * 
     */
    public function createMapAction(){
        
        $newMap = new Map();
        $form = $this->createMapForm($newMap);
        
        return ["form" => $form->createView()];
    }
        
    
    /**
     * @Route("/map/add")
     * @Method({"POST"})
     */
    public function getNewMapDataAction(Request $req){

        $newMap = new Map();
        $form = $this->createMapForm($newMap);
        $form->handleRequest($req);
        
        $file = $newMap->getThumbnail();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('thumbnails_directory'), $fileName);
        $newMap->setThumbnail($fileName);
        
        $this->em()->persist($newMap);
        $this->em()->flush();
        
        return new Response("Dodano nowa mape");
    }
    
    /**
     * @Route ("/map/showAll")
     * @Template("MapBundle:Map:showAllMaps.html.twig")
     */
    
    public function showAllMapAction(){
        
        $repo = $this->getDoctrine()->getRepository("MapBundle:Map");
        $allMaps = $repo->findAll();
        
        return ['allMaps' => $allMaps];
        
    }
    
    /**
     * @Route("/map/show/{id}")
     * @Template("MapBundle:Map:showMap.html.twig")
     */
    
    public function showMapByIdAction($id){
        
        $repo = $this->getDoctrine()->getRepository("MapBundle:Map");
        $map = $repo->find($id);
        
        return ['map' => $map];
    }
    
    /**
     * @Route("user/map/edit/{id}")
     * @Template("MapBundle:Map:editMapPage.html.twig")
     * @Method({"GET"})
     */
    
    public function editMapAction($id){
        
        $repo = $this->getDoctrine()->getRepository("MapBundle:Map");
        $map = $repo->find($id);
        $form = $this->editMapForm($map);
        
        return ["form" => $form->createView()];
    }
    
    /**
     * @Route("user/map/edit/{id}")
     * Template("MapBundle:Map:showAllMaps.html.twig")
     * @Method({"POST"})
     * 
     */
    
    public function getEditedMapDataAction(Request $req, $id){
        
        $repo = $this->getDoctrine()->getRepository("MapBundle:Map");
        $map = $repo->find($id);
        $form = $this->editMapForm($map);
        $form->handleRequest($req);
        
        $this->em()->flush();
        
        return $this->redirectToRoute('map_map_showallmap');
        
    }
    
    
    
    private function createMapForm(Map $map){
        return $this->createFormBuilder($map)
                ->add("code", "text", ["label" => "Godło: "])
                ->add("title", "text", ["label" => "Tytuł: "])
                ->add("scale", "text", ["label" => "Skala: "])
                ->add("publication_date", "date", ["widget" => "single_text", "format" => "yyyy-MM-dd"])
                ->add('thumbnail', 'file', ['label' => 'Dodaj miniature: '])
                ->add("path", "text", ["label" => "Dodaj link do pliku z mapą: "])
                ->add("category", "entity", ["class" => "MapBundle:Category", "choice_label" => "name", "expanded" => false, "multiple" => false])
                ->add("type", "entity", ["class" => "MapBundle:Type", "choice_label" => "name", "expanded" => false, "multiple" => false])
                ->add("Add", "submit")
                ->getForm();
    }
    
        private function editMapForm(Map $map){
        return $this->createFormBuilder($map)
                ->add("code", "text", ["label" => "Godło: "])
                ->add("title", "text", ["label" => "Tytuł: "])
                ->add("scale", "text", ["label" => "Skala: "])
                ->add("publication_date", "date", ["widget" => "single_text", "format" => "yyyy-MM-dd"])
                ->add("path", "text", ["label" => "Dodaj link do pliku z mapą: "])
                ->add("category", "entity", ["class" => "MapBundle:Category", "choice_label" => "name", "expanded" => false, "multiple" => false])
                ->add("type", "entity", ["class" => "MapBundle:Type", "choice_label" => "name", "expanded" => false, "multiple" => false])
                ->add("Add", "submit")
                ->getForm();
    }
    
}
//->setAction($this->generateUrl('add_map'))
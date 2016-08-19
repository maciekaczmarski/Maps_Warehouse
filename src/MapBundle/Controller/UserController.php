<?php

namespace MapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use MapBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserController extends Controller
{

    /**
     * @Route("/admin/create")
     */
    	public function createUserAction() { //użytkowników dodaje tylko jako admin, nie ma możlwiości rejerstracji.
		$userManager = $this->get( 'fos_user.user_manager' );
		$user = $userManager->createUser();
		$user->setUsername( 'Maciek' );
		$user->setEmail( 'maciek@mail.com' );
		$user->setPlainPassword( 'maciek' );
		$user->setEnabled( true );
                $user->setRoles(['ROLE_USER']);
		$userManager->updateUser( $user );

		return new Response( 'added' );
 
}

    /**
     * @Route("/admin/showAll")
     * @Template("MapBundle:User:showAllUsers.html.twig")
     */

    public function showAllUsersAction(){

    $repo = $this->getDoctrine()->getRepository("MapBundle:User");
    $users = $repo->findAll();

    return array('users' => $users);
        
     }
     
     /**
      * @Route("/admin")
      * @Template("MapBundle:User:adminIndex.html.twig")
      */
     
     public function adminAction(){
         
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Nie masz dostępu do tej strony.');
         return [];
     }
     
     /**
      * @Route("/user")
      * @Template("MapBundle:User:userIndex.html.twig")
      */
     
     public function userAction(){
         
         $this->denyAccessUnlessGranted('ROLE_USER', null, 'Nie masz dostepu do tej strony'); 
     }
     
     
     /**
      * @Route("/admin/deleteUser/{id}")
      */
     
     public function deleteUser(){
         
        $repository = $this->getDoctrine()->getRepository("MapBundle:User");
        $user = $repository->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        
        return $this->redirectToRoute('map_user_showallusers');
         
     }
     
         /**
     * @Route ("user/map/showAll")
     * @Template("MapBundle:Map:showAllMaps.html.twig")
     */
    
    public function showAllMapAction(){
        
        $repo = $this->getDoctrine()->getRepository("MapBundle:Map");
        $allMaps = $repo->findAll();
        
        return ['allMaps' => $allMaps];
    }
    
        /**
     * @Route("user/map/show/{id}")
     * @Template("MapBundle:Map:editMapShow.html.twig")
     */
    
    public function showMapByIdAction($id){
        
        $repo = $this->getDoctrine()->getRepository("MapBundle:Map");
        $map = $repo->find($id);
        
        return ['map' => $map];
    }
     
}
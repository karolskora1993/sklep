<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserPanelController extends Controller
{

    /**
     * @Route("/userPanel", name="userPanel")
     */
    public function userPanelAction(){
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('userPanel/aboutUser.html.twig', array('user'=>$user, 'categories'=>$categories));
    }
}

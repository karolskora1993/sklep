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
    /**
     * @Route("/aboutUser", name="aboutUser")
     */
    public function aboutUserAction(){
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('userPanel/aboutUser.html.twig', array('user'=>$user, 'categories'=>$categories));
    }

    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePasswordAction(){
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('@FOSUser/ChangePassword/changePassword.html.twig', array('user'=>$user, 'categories'=>$categories));
    }

    /**
     * @Route("/changeAdress", name="changeAdress")
     */
    public function changeAdressAction(){
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();



        $form = $this->createFormBuilder($user)
            ->add('street', 'text', array(
                'label' => 'ulica',
                'attr'=>array('class'=>'form-control')))
            ->add('number', 'number', array(
                'label' => 'numer domu',
                'attr'=>array('class'=>'form-control')))
            ->add('city', 'text', array(
                'label' => 'miasto',
                'attr'=>array('class'=>'form-control')))
            ->add('zipCode', 'text', array(
                'label' => 'kod pocztowy',
                'attr'=>array('class'=>'form-control')))
            ->add('save', 'submit', array(
                'label' => 'zapisz',
                'attr'=>array('class'=>'form-control')))
            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();
        }
        return $this->render('userPanel/changeAdress.twig', array('user'=>$user, 'categories'=>$categories, 'form'=>$form->createView()));
    }

    /**
     * @Route("/changeEmail", name="changeEmail")
     */
    public function changeEmailAction(){
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();


        $form = $this->createFormBuilder($user)
            ->add('email', 'text', array(
                'label' => 'email',
                'attr'=>array('class'=>'form-control')))
            ->add('save', 'submit', array(
                'label' => 'zapisz',
                'attr'=>array('class'=>'form-control')))
            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();
        }
        return $this->render('userPanel/changeEmail.html.twig', array('user'=>$user, 'categories'=>$categories, 'form'=>$form->createView()));
    }

    /**
     * @Route("/history", name="history")
     */
    public function showHistoryAction(){
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('userPanel/history.html.twig', array('user'=>$user, 'categories'=>$categories));
    }
}

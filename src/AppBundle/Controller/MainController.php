<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\AllValidator;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		$user=$this->getUser();
        return $this->render('main/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
				'user'=>$user,
				 'categories'=>$categories
        ));
    }
	/**
	 * @Route("/about", name="about")
	 */
	public function aboutAction()
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		return $this->render('main/about.html.twig', array('user'=>$user, 'categories'=>$categories));
	}
	/**
	 * @Route("/shop/{category}")
	 */
	public function shopAction($category)
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		$products=$this->getDoctrine()->getRepository('AppBundle:Product')->findAll();

		return $this->render('main/shop.html.twig', array('user'=>$user,'categories'=>$categories, 'category'=>$category, 'products'=>$products));
	}
	/**
	 * @Route("/shop/{category}/{product}")
	 */
	public function shopDetailAction($category, $product)
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		$products=$this->getDoctrine()->getRepository('AppBundle:Product')->findAll();

		return $this->render('main/shop.html.twig', array('user'=>$user,'categories'=>$categories, 'category'=>$product, 'products'=>$products));
	}
	/**
	 * @Route("/basket", name="basket")
	 */
	public function basketAction()
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		return $this->render('main/about.html.twig', array('user'=>$user, 'categories'=>$categories));
	}
	/**
	 * @Route("/checkout", name="checkout")
	 */
	public function checkoutAction()
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		return $this->render('main/about.html.twig', array('user'=>$user, 'categories'=>$categories));
	}
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\AllValidator;
use Symfony\Component\Validator\Constraints\DateTime;

class MainController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction(Request $request)
	{
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		$user=$this->getUser();
		$products=$this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
		$newProducts=[];
		for($i=0; $i<sizeof($products);$i++)
		{
			if($products[$i]->isNew() == true)
				$newProducts[$i]=$products[$i];
		}

		$sale=[];

		for($i=0; $i<sizeof($products);$i++)
		{
			if($products[$i]->isSale() == true)
				$sale[$i]=$products[$i];
		}

		return $this->render('main/index.html.twig', array(
				'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
				'user'=>$user,
				'categories'=>$categories,
				'newProducts'=>$newProducts,
				'sale'=>$sale
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
		$prod=[];
		for($i=0; $i<sizeof($products);$i++)
		{
			if($products[$i]->getCategory() == $category)
				$prod[$i]=$products[$i];
		}

		return $this->render('main/shop.html.twig', array('user'=>$user,'categories'=>$categories, 'category'=>$category, 'products'=>$prod));
	}
	/**
	 * @Route("/shop/{category}/{id}")
	 */
	public function shopDetailAction(Request $request, $id)
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		$product=$this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		$comments=$product->getComments();


		$comment=new Comment();

		$form = $this->createFormBuilder($comment)
				->add('author', 'text')
				->add('text', 'text')
				->add('save', 'submit', array('label' => 'napisz komentarz'))
				->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$comment->setProduct($product);
			$em = $this->getDoctrine()->getManager();

			$em->persist($comment);
			$em->flush();
		}



			return $this->render('main/details.html.twig', array('user'=>$user,'categories'=>$categories, 'product'=>$product, 'form'=>$form->createView(), 'comments'=>$comments));
	}
	/**
	 * @Route("/cart", name="cart")
	 */
	public function basketAction()
	{
		$user=$this->getUser();
		$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		return $this->render('@SyliusCart/Cart/summary.html.twig', array('user'=>$user, 'categories'=>$categories));
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
	/**
	 * @Route("/userPanel", name="userPanel")
	 */
	public function userPanelAction(){

		return $this->forward('AppBundle:UserPanel:userPanel');

	}
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('main/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
	/**
	 * @Route("/bikes/{page}", name="bikes", defaults={"page" = 1})
	 */
	public function bikesAction($page)
	{
		return $this->render('main/bikes.html.twig', array('pageNumber'=>$page));
	}
	/**
	 * @Route("/handlebars/{page}", name="handlebars", defaults={"page" = 1})
	 */
	public function handlebarsAction($page)
	{
		return $this->render('main/handlebars.html.twig', array('pageNumber'=>$page));
	}
    /**
     * @Route("/wheels/{page}", name="wheels", defaults={"page" = 1})
     */
    public function wheelsAction($page)
    {
        return $this->render('main/wheels.html.twig', array('pageNumber'=>$page));
    }
    /**
     * @Route("/frames/{page}", name="frames", defaults={"page" = 1})
     */
    public function framesAction($page)
    {
        return $this->render('main/frames.html.twig', array('pageNumber'=>$page));
    }
    /**
     * @Route("/saddles/{page}", name="saddles", defaults={"page" = 1})
     */
    public function saddlesAction($page)
    {
        return $this->render('main/saddles.html.twig', array('pageNumber'=>$page));
    }
	/**
	 * @Route("/clothes/{page}", name="clothes", defaults={"page" = 1})
	 */
	public function clothesAction($page)
	{
		return $this->render('main/clothes.html.twig', array('pageNumber'=>$page));
	}
	/**
	 * @Route("/about", name="about")
	 */
	public function aboutAction()
	{
		return $this->render('main/about.html.twig');
	}
}

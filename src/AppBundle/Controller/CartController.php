<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/cartAddItem", name="cartAddItem")
     */
    public function cartAddItem(Request $request)
    {
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $user=$this->getUser();

        $session=$request->getSession();

        $cartItems=$session->get('cartItems');

        if($cartItems==null){
            $cartItems=array($request->query->get("productId"));
        }
        else{
            array_push($cartItems,$request->query->get("productId") );
        }

        $session->set('cartItems',$cartItems);

        $route=$request->getBaseUrl();

        $products=[];
        $sum=0;

        for($i=0; $i<sizeof($cartItems);$i++){
            $products[$i]= $this->getDoctrine()->getRepository('AppBundle:Product')->find($cartItems[$i]);
            $sum+=$products[$i]->getPrice();
        }

        return $this->render('cart/cart.html.twig', array(
            'user'=>$user,
            'categories'=>$categories,
            'products'=>$products,
            'sum'=>$sum
        ));
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function showCartAction(Request $request)
    {
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $session=$request->getSession();

        $cartItems=$session->get('cartItems');



        $products=[];
        $sum=0;

        for($i=0; $i<sizeof($cartItems);$i++){
            $products[$i]= $this->getDoctrine()->getRepository('AppBundle:Product')->find($cartItems[$i]);
            $sum+=$products[$i]->getPrice();
        }
        return $this->render('cart/cart.html.twig', array('user'=>$user, 'categories'=>$categories, 'products'=>$products, 'sum'=>$sum));
    }
    /**
     * @Route("/order", name="order")
     */
    public function orderAction(Request $request)
    {
        $user=$this->getUser();
        $categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $session=$request->getSession();

        $cartItems=$session->get('cartItems');



        $products=[];
        $sum=0;

        for($i=0; $i<sizeof($cartItems);$i++){
            $products[$i]= $this->getDoctrine()->getRepository('AppBundle:Product')->find($cartItems[$i]);
            $sum+=$products[$i]->getPrice();
        }
        return $this->render('cart/cart.html.twig', array('user'=>$user, 'categories'=>$categories, 'products'=>$products, 'sum'=>$sum));
    }
}

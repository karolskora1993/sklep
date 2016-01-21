<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
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


        $order=new Orders();
        $order->setIsSent(false);

        $session=$request->getSession();

        $cartItems=$session->get('cartItems');



        $products=[];
        $sum=0;

        for($i=0; $i<sizeof($cartItems);$i++){
            $products[$i]= $this->getDoctrine()->getRepository('AppBundle:Product')->find($cartItems[$i]);
            $sum+=$products[$i]->getPrice();
        }
        $order->setProducts($products);
        $order->setTotalCost($sum);
        $order->setUser($user);

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
                'label' => 'zamów',
                'attr'=>array('class'=>'form-control')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prevOrders=$user->getOrders();
            $prevOrders->add($order);
            $user->setOrders($prevOrders);


            for($i=0; $i<sizeof($products);$i++){
                $products[$i]->setQuantity($products[$i]->getQuantity()-1);
            }
            $session->set('cartItems', array());
            $em = $this->getDoctrine()->getManager();

            $em->persist($order);
            $em->flush();
            return $this->render('cart/ordered.html.twig', array('user'=>$user, 'categories'=>$categories));
        }

        return $this->render('cart/order.html.twig', array('user'=>$user, 'categories'=>$categories, 'form'=>$form->createView() ));
    }
}

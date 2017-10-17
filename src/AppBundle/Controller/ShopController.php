<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    /**
     * @Route("/shop/create", name="create")
     */
    public function createProductAction()
    {
        $category = new Category();
        $category->setTitle('Fruits');

        $product = new Product();
        $product->setTitle('Apple');
        $product->setPrice(1.99);
        $product->setActive(1);
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        //add cascade parameter to $category property in Product entity instead
//        $em->persist($category);
        $em->persist($product);
        $em->flush();

        return new Response(
            'Saved new product with id: ' . $product->getId()
            . ' and new category with id: ' . $category->getId()
        );

    }

    /**
     * @Route("/shop/delete/{productId}", name="deleteProduct")
     */
    public function deleteProductAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getReference('AppBundle:Product', $productId);

        $em->remove($product);
        $em->flush();

        return new Response('Product removed');
    }
}

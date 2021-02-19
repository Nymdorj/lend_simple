<?php

namespace App\Controller;

use App\Entity\Product;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shop", name="shop.")
 */
class ShopController extends AbstractController
{
    /**
     * Багцын мэдээллийг харуулах
     * @Route("/collection/{collectionid?}", name="collection", methods={"GET"})
     */
    public function collection($collectionid)
    {
        if ($collectionid) {
            // Багцын дугаар байвал тухайн багцын бүтээгдэхүүнүүдийг харуулна.
            $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['collectionid' => $collectionid]);
        } else {
            // Багцын дугаар байхгүй бол бүх бүтээгдэхүүнүүдийг харуулна.
            $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        }

        $session = $this->get('session');
        $cartCount = $session->get('cartCount');
        return $this->render('shop/shop.html.twig', [
            'cartCount' => $cartCount,
            'products' => $products
        ]);
    }

    /**
     * Бүтээгдэхүүний мэдээллийг харуулах
     * @Route("/product/{id}", name="product", methods={"GET"})
     */
    public function product(Product $product)
    {
        $session = $this->get('session');
        $cartCount = $session->get('cartCount');

        return $this->render('shop/product.html.twig', [
            'cartCount' => $cartCount,
            'product' => $product
        ]);
    }
}

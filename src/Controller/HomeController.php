<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Collection;
use App\Entity\Product;
use App\LendAPI\Access;
use App\LendAPI\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index()
    {
        // Session -с хэрэглэгчийн дугаар болон токен авав.
        $session = $this->get('session');
        $accessToken = $session->get('accessToken') ?? null;
        $userId = $session->get('userId') ?? null;

        // токен байхгүй бол шинэ токен авна.
        if ($accessToken == null) {
            $code = $_GET['code'] ?? null;
            $token = new Access($code);
            if ($token->getErrorMsg() != '') {
                return $this->render('error.html.twig', ['errorMsg' => 'Code is empty']);
            }

            $user = new User($token->getAccessToken());
            if ($user->getErrorMsg() != '') {
                return $this->render('error.html.twig', ['errorMsg' => $user->getErrorMsg()]);
            }

            $userId = $user->getUserId();
            $session->set('accessToken', $token->getAccessToken());
            $session->set('userId', $userId);
        }

        // Сагс, бүтээгдэхүүнүүд болон багцын мэдээллийг авна.
        $carts       = $this->getDoctrine()->getRepository(Cart::class)->getCartItems($userId);
        $products    = $this->getDoctrine()->getRepository(Product::class)->findBy([], [], 5);
        $collections = $this->getDoctrine()->getRepository(Collection::class)->findAll();

        $cartCount = sizeof($carts);
        $session->set('cartCount', $cartCount);
        return $this->render('shop/index.html.twig', [
            'cartCount' => $cartCount,
            'products' => $products,
            'collections' => $collections
        ]);
    }
}

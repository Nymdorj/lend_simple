<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\LendAPI\Invoice;
use App\LendAPI\Config;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart.")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function cart()
    {
        //Сагсан дахь бүтээгдэхүүнүүдийн мэдээллийг гаргана.
        $session   = $this->get('session');
        $userId    = $session->get('userId');

        $carts = $this->getDoctrine()->getRepository(Cart::class)->getCartItems($userId);

        return $this->render('cart/cart.html.twig', [
            'cartCount' => sizeof($carts),
            'carts'     => $carts
        ]);
    }

    /**
     * Хэрэглэгчийн захиалгыг сагсанд хадгална.
     * @Route("/add", name="add", methods={"POST"})
     * @param request - захиалгын мэдээлэл
     */
    public function addCart(Request $request)
    {
        $cart = new Cart();
        $productId = $request->get('product-id');
        $quantity  = $request->get('product-quantity');
        $size      = $request->get('size-select');
        $color     = $request->get('color-select');
        $material  = $request->get('material-select');

        $session = $this->get('session');
        $userId = $session->get('userId');
        $cartCount = $session->get('cartCount');

        $cart->setProductid($productId);
        $cart->setQuantity($quantity);
        $cart->setSize($size);
        $cart->setColor($color);
        $cart->setMaterial($material);
        $cart->setUserid($userId);

        $cartCount += 1;
        $session->set('cartCount', $cartCount);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cart);
        $entityManager->flush();

        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);
        return $this->render('shop/product.html.twig', [
            'cartCount' => $cartCount,
            'product'   => $product
        ]);
    }

    /**
     * Нэмэжлэл төлөгдсөн эсэх мэдээллийг харуулна.
     * @Route("/success", name="success")
     * @param request - захиалгын дугаар
     */
    public function success(Request $request)
    {
        $orderId = $request->query->get('order_id');

        $order = $this->getDoctrine()->getRepository(Order::class)->find($orderId);

        $session = $this->get('session');
        $accessToken = $session->get('accessToken');

        $invoice = Invoice::invoiceDetail($accessToken, $order->getInvoiceNumber());

        if ($invoice['success'] == true) {
            $status = $invoice['msg']['status'];

            switch ($status) {
                case 0:
                    $order->setStatus('STATUS_PENDING');
                    $statusMsg = 'хүлээгдэж байна.';
                    break;
                case 1:
                    $order->setStatus('STATUS_COMPLETE');
                    $statusMsg = 'амжилттай төлөгдлөө.';
                    break;
                case 2:
                    $order->setStatus('STATUS_CANCELED');
                    $statusMsg = 'цуцлагдлаа.';
                    break;
                case 3:
                    $order->setStatus('STATUS_FAILED');
                    $statusMsg = 'алдаа гарлаа.';
                    break;
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
        }

        return $this->render('cart/success.html.twig', [
            'order'     => $order,
            'invoice'   => $invoice,
            'statusmsg' => $statusMsg
        ]);
    }

    /**
     * Нэхэмжлэл үүсгэх
     * @Route("/invoice", name="invoice", methods={"POST"})
     */
    public function invoice(Request $request)
    {
        $session = $this->get('session');
        $accessToken = $session->get('accessToken');
        $userId = $session->get('userId');
        $cartIds = $request->get('cart-ids');

        // Захиалгыг хадгалах хэсэг
        $order = new Order();
        $order->setUserId($userId);
        $order->setAmount($request->get('total-pay'));
        $order->setStatus('PENDING');

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        $orderId = $order->getId();

        // Нэхэмжлэл үүсгэх
        $invoice = new Invoice($request->get('total-pay'), Config::DURATION, "Team2#$orderId", "/cart/success?order_id=$orderId", $orderId, $accessToken);
        $invoice->createInvoice();

        if ($invoice->getErrorMsg() != null) {
            return $this->render('error.html.twig', ['errorMsg' => $invoice->getErrorMsg()]);
        }

        // Захиалгыг нэхэмжлэлийн дугаараар шинэчлэх 
        $order->setInvoiceNumber($invoice->getInvoiceNumber());
        $em->persist($order);

        // Сагсны мэдээллийг захиалгын дугаараар шинэчилж сагсыг хоослох
        foreach ($cartIds as $cartId) {
            $cart = $this->getDoctrine()->getRepository(Cart::class)->find($cartId);
            $cart->setOrderId($orderId);
            $em->persist($cart);
        }
        $session->set('cartCount', 0);

        $em->flush();

        return $this->render('cart/pay.html.twig', [
            'orderId'       => $orderId,
            'invoiceNumber' => $invoice->getInvoiceNumber(),
            'amount'        => $order->getAmount(),
            'duration'      => Config::DURATION
        ]);
    }
}

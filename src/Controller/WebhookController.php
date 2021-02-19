<?php

namespace App\Controller;

use App\Entity\Order;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    /**
     * @Route("/webhook", name="webhook")
     */
    public function index()
    {
        // json data received
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        //If json_decode failed, the JSON is invalid.
        if (!is_array($decoded)) {
            throw new Exception('Received content contained invalid JSON!');
        }

        // received event
        $eventType = $decoded['eventType'];
        $data      = $decoded['data'];
        $signature = $decoded['signature'];

        unset($decoded['signature']);

        // public key
        $publicKey = '../../data' . DIRECTORY_SEPARATOR . 'public.pem';
        $publicKeyPem = openssl_pkey_get_public(file_get_contents($publicKey));
        $dataNotVerified = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        // verify signature
        $isValid = openssl_verify($dataNotVerified, base64_decode($signature), $publicKeyPem, 'sha256WithRSAEncryption');

        // if data is not valid
        if (0 == $isValid) {
            throw new Exception('Signature error!');
        };

        // find order by invoice number
        $order = $this->getDoctrine()->getRepository(Order::class)->findBy(['invoice_number' => $data['invoiceNumber']]);

        switch ($eventType) {
            case 'invoice.paid':
                $order->setStatus('STATUS_COMPLETE');
                break;
            case 'invoice.cancelled':
                $order->setStatus('STATUS_CANCELED');
                break;
            case 'invoice.expired':
                $order->setStatus('STATUS_FAILED');
                break;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        return new JsonResponse([
            'code' => 0, 'response' => ['message' => 'OK']
        ]);
    }
}

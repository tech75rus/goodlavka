<?php

namespace App\Controller\Shop;

use App\Entity\Cart;
use App\Entity\Payment;
use App\Entity\PaymentDetail;
use App\Entity\ProductsCart;
use App\Entity\Shop\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use YooKassa\Client;

class PayController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/shop/test-pay', methods: ['POST'])]
    #[IsGranted("ROLE_GUEST")]
    public function testPay(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Cart $cart */
        $cart = $user->getCart();

        $client = new Client();
        $client->setAuth('877284', 'test_BOCe1av5wyDo7qQF6qpmp1z6QabCijx3CAc2bWCxJgk');
        $key = Uuid::v4();
        $response = $client->createPayment(
            [
                'amount' => [
                    'value' => $cart->getPrice(),
                    'currency' => 'RUB',
                ],
                'payment_method_data' => [
                    'type' => 'bank_card',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => 'https://goodlavka.com',
                ],
                'capture' => $cart->getPrice() < 10000,
                'description' => 'Заказ №53',
            ],
            $key
        );
        if (!$response) {
            return new Response('Ошибка при оплате', 401);
        }
        $payment = new Payment();
        $payment->setIdUser($user);
        $payment->setIdYookassa($response->getId());
        $payment->setPrice($cart->getPrice());
        $payment->setStatus($response->getStatus());
        $payment->setAtCreate(new \DateTime());
        $payment->setAtUpdate(new \DateTime());

        $products = $cart->getProductsCarts();
        /** @var ProductsCart $product */
        foreach ($products as $product) {
            $paymentDetail = new PaymentDetail();
            $paymentDetail->setIdPayment($payment);
            $paymentDetail->setIdProduct($product->getProduct());
            $paymentDetail->setName('product');
            $paymentDetail->setPrice($product->getProduct()->getPrice());
            $paymentDetail->setCount($product->getCount());
            $paymentDetail->setDescription($product->getProduct()->getDescription());
            $this->entityManager->persist($paymentDetail);
        }
        $this->entityManager->persist($payment);

        $cart->clearCart();
        foreach ($products as $prod) {
            $this->entityManager->remove($prod);
        }
        $cart->setPrice('0');

        $this->entityManager->flush();
        $result = $response->getConfirmation()->getConfirmationUrl();
        return $this->json($result);
    }
}

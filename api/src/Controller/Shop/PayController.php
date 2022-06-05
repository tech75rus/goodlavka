<?php

namespace App\Controller\Shop;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use YooKassa\Client;

class PayController extends AbstractController
{
    #[Route('/shop/test-pay')]
    #[IsGranted("ROLE_GUEST")]
    public function testPay(): Response
    {
        dd($this->getUser());
        $client = new Client();
        $client->setAuth('877284', 'test_BOCe1av5wyDo7qQF6qpmp1z6QabCijx3CAc2bWCxJgk');
        //$key = uniqid('', true);
        $key = Uuid::v4();
        $response = $client->createPayment(
            [
                'amount' => [
                    'value' => '998.34',
                    'currency' => 'RUB',
                ],
                'payment_method_data' => [
                    'type' => 'bank_card',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => 'https://goodlavka.com',
                ],
                'capture' => true,
                'description' => 'Заказ №53',
            ],
            $key
        );
        $result = $response->getConfirmation()->getConfirmationUrl();
        return new Response($result);
    }
}

<?php

namespace Omnipay\NABTransact;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\NABTransact\Tests\Lib;

class PeriodicGatewayTest extends GatewayTestCase
{
    use Lib\fakerTrait;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = new PeriodicGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCreateCard()
    {
        $expiry = explode('/', self::$faker->creditCardExpirationDateString);
        $card = [
            'number' => self::$faker->creditCardNumber,
            'expiryMonth' => $expiry[0],
            'expiryYear' => $expiry[1],
            'cvv' => self::$faker->randomNumber(3),
        ];

        $request = $this->gateway->createCard(['card' => $card]);

        $this->assertInstanceOf('Omnipay\NABTransact\Message\PeriodicCreateCustomerRequest', $request);
        return $card;
    }

    public function testUpdateCard()
    {
        $expiry = explode('/', self::$faker->creditCardExpirationDateString);
        $card = [
            'number' => self::$faker->creditCardNumber,
            'expiryMonth' => $expiry[0],
            'expiryYear' => $expiry[1],
            'cvv' => self::$faker->randomNumber(3),
        ];

        $request = $this->gateway->updateCard(['card' => $card]);

        $this->assertInstanceOf('Omnipay\NABTransact\Message\PeriodicUpdateCustomerRequest', $request);
        return $card;
    }
}

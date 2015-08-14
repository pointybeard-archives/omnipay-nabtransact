<?php

namespace Omnipay\NABTransact\Message;

use Omnipay\Tests\TestCase;
use Omnipay\NABTransact\Tests\Lib;

class PeriodicCreateCustomerRequestTest extends TestCase
{
    use Lib\fakerTrait;
	private static $request;
	
	public function setUp(){
		self::$request = new PeriodicCreateCustomerRequest($this->getHttpClient(), $this->getHttpRequest());
	}

    public function testGetData()
    {
		$expiry = explode('/', self::$faker->creditCardExpirationDateString);
		$details = [
            'merchantID' => 'XYZ0010',
            'password' => 'abcd1234',
			'testMode' => true,
			'apiVersion' => 'spxml-4.2',
			'card' => [
                'number' => self::$faker->creditCardNumber,
                'expiryMonth' => $expiry[0],
                'expiryYear' => $expiry[1],
                'cvv' => self::$faker->randomNumber(3),
			],
		];

        self::$request->initialize($details);
		
        $data = self::$request->getData();

        $this->assertSame($details['card']['number'], $data['Customer']['CardDetails']['Number']);
        $this->assertSame($details['card']['expiryMonth'], $data['Customer']['CardDetails']['ExpiryMonth']);
		$this->assertSame($details['card']['expiryYear'], $data['Customer']['CardDetails']['ExpiryYear']);
		
		return $details;
    }
	/**
	 * @depends testGetData
	 */
    public function testSendSuccess(array $details)
    {
		self::$request->initialize($details);

        $this->setMockHttpResponse('PeriodicCreateCustomerRequestSuccess.txt');
        $response = self::$request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('00', $response->getCode());
        $this->assertSame('Successful', $response->getMessage());
		return $details;
    }
	/**
	 * @depends testGetData
	 */
    public function testSendFailure(array $details)
    {
		self::$request->initialize($details);

        $this->setMockHttpResponse('PeriodicCreateCustomerRequestFailure.txt');
        $response = self::$request->send();
    
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('346', $response->getCode());
        $this->assertSame('Duplicate CRN Found', $response->getMessage());
		return $details;
    }
}

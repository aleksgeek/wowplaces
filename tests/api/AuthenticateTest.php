<?php

use GuzzleHttp\Client;

class AuthenticateTest extends TestCase
{
	private $guzzle_client;

	public function setUp()
	{
		parent::setup();
		$this->guzzle_client = new Client();
	}

	public function testAuth()
	{
		$resp = $this->guzzle_client->request('POST', route('post-auth'), [
		    'form_params' => [
		    	'email' => env('TEST_LOGIN'), 
		    	'password' => env('TEST_PASSWORD')
		    ]
		]);

		$this->assertEquals('200', $resp->getStatusCode());

		$answer = $resp->getBody();
		$points_count = substr_count($answer, '.');
		$this->assertEquals(2, $points_count);
	}

    /**
     * @dataProvider getCredentials
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 422
     */
	public function testAuthBadCredentials($email, $pass)
	{
		$resp = $this->guzzle_client->request('POST', route('post-auth'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		    'form_params' => [
		    	'email' => $email, 
		    	'password' => $pass
		    ]
		]);
	}

	public function getCredentials()
	{
		return [
			[env('TEST_LOGIN'), ''],
			['test', 'test'],
			['', env('TEST_PASSWORD')],
			['', ''],
		];
	}
}
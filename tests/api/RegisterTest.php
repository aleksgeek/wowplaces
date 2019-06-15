<?php

use GuzzleHttp\Client;
use App\Models\Users;
use Illuminate\Contracts\Cache\Factory;

class RegisterTest extends TestCase
{
	private $guzzleClient;	

	public function setUp()
	{
		parent::setup();
		$this->guzzleClient = new Client();
	}

    /**
     * @dataProvider getRegisterData
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 422
     */
	public function atestRegisterExceptions($name, $email, $pass, $passConfirm)
	{
		$resp  = $this->guzzleClient->request('POST', route('post-register'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		    'form_params' => [
		    	'name'  => $name,
		    	'email' => $email, 
		    	'password' => $pass,
		    	'password_confirmation' => $passConfirm
		    ]
		]);		
	}

	public function getRegisterData()
	{
		return [
			['', 'test_er@t.com', env('TEST_PASSWORD'), env('TEST_PASSWORD')],
			['test_er', '', env('TEST_PASSWORD'), env('TEST_PASSWORD')],
			['test_er', 'test_er@t.com', '', env('TEST_PASSWORD')],
			['test_er', 'test_er@t.com', env('TEST_PASSWORD'), ''],
			['test_er', 'test_er@t.com', '', ''],
		];
	}


	public function testRegister()
	{
		$email = 'test1@t.com';
		$resp  = $this->guzzleClient->request('POST', route('post-register'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		    'form_params' => [
		    	'name'  => 'test1',
		    	'email' => $email, 
		    	'password' => env('TEST_PASSWORD'),
		    	'password_confirmation' => env('TEST_PASSWORD')
		    ]
		]);

		$this->assertEquals('200', $resp->getStatusCode());
		$approve_param = Cache::get('approve_param_'.$email);

		return ['approve_param'=>$approve_param, 'email'=>$email];
	}

	/**
     * @depends testRegister
     */
	public function testRegisterApprove($arr)
	{
		$resp = $this->guzzleClient->request('GET', route('register-approve', ['approve_param'=>$arr['approve_param']]), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest']
		]);	
		
		Users::where('email', $arr['email'])->delete();
	}

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 401
     */
	public function testRegisterApproveExceptions()
	{
		$resp = $this->guzzleClient->request('GET', route('register-approve', ['approve_param'=>'test']), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest']
		]);		
	}

}
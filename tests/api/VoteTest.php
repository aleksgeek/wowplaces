<?php

use GuzzleHttp\Client;
use App\Models\UsersVotes;

class VoteTest extends TestCase
{
	private $guzzle_client;	
	private $token;
	private $test_object_id = 1;

	public function setUp()
	{
		parent::setup();
		$this->guzzle_client = new Client();
		$this->token = $this->getAuthToken();
	}

	/**
	 * @expectedException GuzzleHttp\Exception\ClientException
	 * @expectedExceptionCode 400
	 */
	public function testMakeVotingTokenException()
	{
		$resp  = $this->guzzle_client->request('POST', route('post-vote'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		    'form_params' => [
		    	'id_object'  => $this->test_object_id,
		    	'rating' => 'up'
		    ]
		]);	
	}

	/**
	 * @expectedException GuzzleHttp\Exception\ClientException
	 * @expectedExceptionCode 401
	 */
	public function testMakeVotingAuthException()
	{
		$resp  = $this->guzzle_client->request('POST', route('post-vote'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest', 'Authorization'=>'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidGVzdCIsImVtYWlsIjoibG9jYWxob3N0QHQuY29tIiwic3ViIjo1LCJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwN1wvd293cGxhY2VzXC9wdWJsaWNcL2luZGV4LnBocFwvYXBpXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE0ODczMTcwNDksImV4cCI6MTQ4NzMyMDY0OSwibmJmIjoxNDg3MzE3MDQ5LCJqdGkiOiIwMWJiMmM4NzRmMTc1YjY2ZmNmMTcwMDZlYjFjNjM3YyJ9.3Vl7RFuzrNBuL86e-P4T-09giAVv_SoWww5kDLtkTvg'],
		    'form_params' => [
		    	'id_object'  => $this->test_object_id,
		    	'rating' => 'up'
		    ]
		]);	
	}

	/**
	 * @expectedException GuzzleHttp\Exception\ClientException
	 * @expectedExceptionCode 400
	 */
	public function testMakeVotingBadData()
	{
		$resp  = $this->guzzle_client->request('POST', route('post-vote'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest', 'Authorization'=>'Bearer '.$this->token],
		    'form_params' => [
		    	'id_object'  => $this->test_object_id,
		    	'rating' => ''
		    ]
		]);	
	}

    /**
     * @dataProvider getVoteData
     */
	public function testMakeVoting($rating)
	{
		UsersVotes::where('id_object', $this->test_object_id)->delete();

		$resp  = $this->guzzle_client->request('POST', route('post-vote'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest', 'Authorization'=>'Bearer '.$this->token],
		    'form_params' => [
		    	'id_object'  => $this->test_object_id,
		    	'rating' => $rating
		    ]
		]);	
		$this->assertEquals('200', $resp->getStatusCode());
	}

	public function getVoteData()
	{
		return [
			['up'], ['down']
		];		
	}


	private function getAuthToken()
	{
		$resp = $this->guzzle_client->request('POST', route('post-auth'), [
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		    'form_params' => [
		    	'email' => env('TEST_LOGIN'), 
		    	'password' => env('TEST_PASSWORD')
		    ]
		]);

		$token = json_decode($resp->getBody());
		
		return $token;
	}
}
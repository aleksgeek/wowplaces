<?php

use GuzzleHttp\Client;
use App\Models\UsersVotes;

class VoteTest extends TestCase
{
    private $guzzleClient;  
    private $token;
    private $testObjectId = 1;

    public function setUp(): void
    {
        parent::setup();
        $this->guzzleClient = new Client();
        $this->token = $this->getAuthToken();
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 400
     */
    public function testMakeVotingTokenException()
    {
        $resp  = $this->guzzleClient->request('POST', route('post-vote'), [
            'headers' => ['X-Requested-With' => 'XMLHttpRequest', 'Authorization'=>'Bearer '.$this->token],
            'form_params' => [
                'id_object'  => $this->testObjectId,
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
        $resp  = $this->guzzleClient->request('POST', route('post-vote'), [
            'headers' => ['X-Requested-With' => 'XMLHttpRequest', 'Authorization'=>'Bearer '.$this->token],
            'form_params' => [
                'id_object'  => $this->testObjectId,
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
        $resp  = $this->guzzleClient->request('POST', route('post-vote'), [
            'headers' => ['X-Requested-With' => 'XMLHttpRequest', 'Authorization'=>'Bearer '.$this->token],
            'form_params' => [
                'id_object'  => $this->testObjectId,
                'rating' => ''
            ]
        ]); 
    }

    private function getAuthToken()
    {
        $resp = $this->guzzleClient->request('POST', route('post-auth'), [
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
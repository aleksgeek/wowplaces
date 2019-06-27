<?php

use GuzzleHttp\Client;
use App\Models\Users;
use Illuminate\Contracts\Cache\Factory;

class RegisterTest extends TestCase
{
    private $guzzleClient;  

    public function setUp(): void
    {
        parent::setup();
        $this->guzzleClient = new Client();
    }

    /**
     * @dataProvider getRegisterData
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 422
     */
    public function testRegisterExceptions($name, $email, $pass, $passConfirm)
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
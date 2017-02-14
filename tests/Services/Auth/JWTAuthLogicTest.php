<?php

use App\Services\Auth\AuthLogic;
use App\Services\Auth\JWTAuthLogic;
use Illuminate\Cache\Repository as Cache;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Auth\Access\AuthorizationException;

class JWTAuthLogicTest extends TestCase
{
    protected $auth_logic;
    protected $cache_mock;
    protected $jwt_auth;

    public function setUp()
    {
        $this->cache_mock = $this->getMockBuilder(Cache::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->jwt_auth = $this->getMockBuilder(JWTAuth::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->auth_logic = new JWTAuthLogic($this->cache_mock, $this->jwt_auth);
    }

    public function testGetToken()
    {
        $this->jwt_auth->expects($this->any())
        ->method('attempt')
        ->will($this->returnValue(
            'token'
        ));

        $token = $this->auth_logic->getToken(['email'=>'', 'password'=>''], ['test user']); 
        $this->assertEquals('token', $token);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 401
     */
    public function testGetTokenException()
    {
        $this->jwt_auth->expects($this->any())
        ->method('attempt')
        ->will($this->returnValue(
            ''
        ));
        
        $this->auth_logic->getToken(['email'=>'', 'password'=>''], ['test user']); 
    }

    public function testGetTokenError()
    {
        try{
            $this->auth_logic->getToken('', ''); 
            $this->assertTrue(false);     
        }catch(Error $e){
            $this->assertEquals(0, $e->getCode());
        }
    }

    public function testCreateApproveRegisterParam()
    {
        $approve_param = $this->auth_logic->createApproveRegisterParam(['email'=>'', 'password'=>'']);
        $this->assertInternalType('string', $approve_param);
    }

    public function testCreateApproveRegisterParamError()
    {
        try{
            $approve_param = $this->auth_logic->createApproveRegisterParam('');  
            $this->assertTrue(false);     
        }catch(Error $e){
            $this->assertEquals(0, $e->getCode());
        }
    }

    public function testGetApproveRegisterCredentials()
    {
        $this->cache_mock->expects($this->any())
        ->method('get')
        ->will($this->returnValue(
            '{"email":"", "password":""}'
        ));

        $credentails = $this->auth_logic->getApproveRegisterCredentials('somestring');
        $this->assertEquals(['email'=>'', 'password'=>''], $credentails);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 401
     */
    public function testGetApproveRegisterCredentialsException()
    {
        $this->cache_mock->expects($this->any())
        ->method('get')
        ->will($this->returnValue(
            ''
        ));

        $credentails = $this->auth_logic->getApproveRegisterCredentials('somestring');
    }

    public function testGetApproveRegisterCredentialsError()
    {
        $this->cache_mock->expects($this->any())
        ->method('get')
        ->will($this->returnValue(
            'test'
        ));
        
        try{ 
            $credentails = $this->auth_logic->getApproveRegisterCredentials('somestring');
            ///$this->assertTrue(false);
        }catch(Error $e){
            $this->assertEquals(0, $e->getCode());
        }
    }

    public function testGetAuthenticatedUser()
    {
        $test_user = (object)['id'=>0, 'name'=>'test'];

        $this->jwt_auth->expects($this->any())
        ->method('parseToken')
        ->will($this->returnValue(
            new class{
                public function authenticate()
                {
                    return (object)['id'=>0, 'name'=>'test'];
                }
            } 
        ));

        $user = $this->auth_logic->getAuthenticatedUser();
        $this->assertEquals($user, $test_user);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 404
     */
    public function testGetAuthenticatedUserException()
    {
        $this->jwt_auth->expects($this->any())
        ->method('parseToken')
        ->will($this->returnValue(
            new class{
                public function authenticate()
                {
                    return false;
                }
            } 
        ));

        $this->auth_logic->getAuthenticatedUser();
    }
}
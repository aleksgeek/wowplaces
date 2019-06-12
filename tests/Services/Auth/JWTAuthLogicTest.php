<?php

use App\Services\Auth\AuthLogic;
use App\Services\Auth\JWTAuthLogic;
use Illuminate\Cache\Repository as Cache;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Auth\Access\AuthorizationException;

class JWTAuthLogicTest extends TestCase
{
    protected $authLogic;
    protected $cacheMock;
    protected $jwtAuth;

    public function setUp()
    {
        $this->cacheMock = $this->getMockBuilder(Cache::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->jwtAuth = $this->getMockBuilder(JWTAuth::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->authLogic = new JWTAuthLogic($this->cacheMock, $this->jwtAuth);
    }

    public function testGetToken()
    {
        $this->jwtAuth->expects($this->any())
        ->method('attempt')
        ->will($this->returnValue(
            'token'
        ));

        $token = $this->authLogic->getToken(['email'=>'', 'password'=>''], ['test user']); 
        $this->assertEquals('token', $token);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 401
     */
    public function testGetTokenException()
    {
        $this->jwtAuth->expects($this->any())
        ->method('attempt')
        ->will($this->returnValue(
            ''
        ));
        
        $this->authLogic->getToken(['email'=>'', 'password'=>''], ['test user']); 
    }

    public function testGetTokenError()
    {
        try{
            $this->authLogic->getToken('', ''); 
            $this->assertTrue(false);     
        }catch(Error $e){
            $this->assertEquals(0, $e->getCode());
        }
    }

    public function testCreateApproveRegisterParam()
    {
        $approveParam = $this->authLogic->createApproveRegisterParam(['email'=>'', 'password'=>'']);
        $this->assertInternalType('string', $approveParam);
    }

    public function testCreateApproveRegisterParamError()
    {
        try{
            $approveParam = $this->authLogic->createApproveRegisterParam('');  
            $this->assertTrue(false);     
        }catch(Error $e){
            $this->assertEquals(0, $e->getCode());
        }
    }

    public function testGetApproveRegisterCredentials()
    {
        $this->cacheMock->expects($this->any())
        ->method('get')
        ->will($this->returnValue(
            '{"email":"", "password":""}'
        ));

        $credentails = $this->authLogic->getApproveRegisterCredentials('somestring');
        $this->assertEquals(['email'=>'', 'password'=>''], $credentails);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 401
     */
    public function testGetApproveRegisterCredentialsException()
    {
        $this->cacheMock->expects($this->any())
        ->method('get')
        ->will($this->returnValue(
            ''
        ));

        $credentails = $this->authLogic->getApproveRegisterCredentials('somestring');
    }

    public function testGetApproveRegisterCredentialsError()
    {
        $this->cacheMock->expects($this->any())
        ->method('get')
        ->will($this->returnValue(
            'test'
        ));
        
        try{ 
            $credentails = $this->authLogic->getApproveRegisterCredentials('somestring');
            ///$this->assertTrue(false);
        }catch(Error $e){
            $this->assertEquals(0, $e->getCode());
        }
    }

    public function testGetAuthenticatedUser()
    {
        $testUser = (object)['id'=>0, 'name'=>'test'];

        $this->jwtAuth->expects($this->any())
        ->method('parseToken')
        ->will($this->returnValue(
            new class{
                public function authenticate()
                {
                    return (object)['id'=>0, 'name'=>'test'];
                }
            } 
        ));

        $user = $this->authLogic->getAuthenticatedUser();
        $this->assertEquals($user, $testUser);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 404
     */
    public function testGetAuthenticatedUserException()
    {
        $this->jwtAuth->expects($this->any())
        ->method('parseToken')
        ->will($this->returnValue(
            new class{
                public function authenticate()
                {
                    return false;
                }
            } 
        ));

        $this->authLogic->getAuthenticatedUser();
    }
}
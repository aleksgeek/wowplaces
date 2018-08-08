<?php
namespace App\Services\Auth;

use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Cache\Repository as Cache;

class JWTAuthLogic implements AuthLogic
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var JWTAuth
     */
    protected $jwtAuth;

    public function __construct(Cache $cache, JWTAuth $jwtAuth)
    {
        $this->cache = $cache;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Creating jwt token by user credentials.
     *
     * @param  array $credentials
     * @param  App\Models\Users $user
     * @return string
     *
     * @throws AuthorizationException
     */
    public function getToken($credentials, $user)
    {
		$customClaims = ['email'=>$user->email, 'name'=>$user->name];
		
	    $token = $this->jwtAuth->attempt($credentials, $customClaims);

	    if (trim($token)) {
            return $token;
        }

        throw new AuthorizationException("cannot create auth jwt token, email - {$credentials['email']}", 401);
    }

    /**
     * create md5 param for approve registering and store it to cache
     *
     * @param  array $credentials
     * @return string
     */ 
    public function createApproveRegisterParam(array $credentials)
    {
        $jsonCredentials = json_encode($credentials);
        $md5Credentails  = md5($jsonCredentials.'_'.date("Y-m-d H:i:s"));

        $this->cache->add($md5Credentails, $jsonCredentials, 12);

        return $md5Credentails;           
    }

    /**
     * get user credentails from cache (md5 hash)
     *
     * @param  string $approve_param
     * @return array
     *
     * @throws AuthorizationException
     */ 
    public function getApproveRegisterCredentials($approveParam)
    {
        $jsonCredentials = $this->cache->get($approveParam);

        if($jsonCredentials){
            return json_decode($jsonCredentials, 1);
        }

        throw new AuthorizationException("register approve_param is invalid", 401);
    }

    /**
     * get user from Authorization header
     *
     * @return object
     *
     * @throws AuthorizationException
     */
    public function getAuthenticatedUser()
    {
        $user = $this->jwtAuth->parseToken()->authenticate(); 

        if ($user) {
            return $user;
        }    

        throw new AuthorizationException("authenticated user not found", 404);
    }
}

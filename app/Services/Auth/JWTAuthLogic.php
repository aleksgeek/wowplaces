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
    protected $jwt_auth;

    public function __construct(Cache $cache, JWTAuth $jwt_auth)
    {
        $this->cache = $cache;
        $this->jwt_auth = $jwt_auth;
    }

    /**
     * Creating jwt token by user credentials. This token contains user data ($custom_claims)
     *
     * @return string
     * @throws AuthorizationException
     */
    public function getToken(array $credentials, array $custom_claims)
    {
	    $token = $this->jwt_auth->attempt($credentials, $custom_claims);

	    if (trim($token)) {
            return $token;
        }

        throw new AuthorizationException("invalid credentials", 401);
    }

    /**
     * create md5 param for approve registering and store it to cache
     *
     * @return string
     */ 
    public function createApproveRegisterParam(array $credentials)
    {
        $json_credentials = json_encode($credentials);
        $md5_credentails  = md5($json_credentials.'_'.date("Y-m-d H:i:s"));

        $this->cache->add($md5_credentails, $json_credentials, 12);

        return $md5_credentails;           
    }

    /**
     * get user credentails from cache (md5 hash)
     *
     * @param  string 
     * @return array
     * @throws AuthorizationException
     */ 
    public function getApproveRegisterCredentials($approve_param)
    {
        $json_credentials = $this->cache->get($approve_param);

        if($json_credentials){
            return json_decode($json_credentials, 1);
        }

        throw new AuthorizationException("confirm registration error", 401);
    }
}

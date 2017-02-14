<?php
namespace App\Services\Auth;

interface AuthLogic
{
	/**
	 * get user token	
	 */
	public function getToken(array $credentials, array $custom_claims);

	/**
	 * create md5 param
	 */	
	public function createApproveRegisterParam(array $credentials);

    /**
     * get user credentails by hash param  
     */
	public function getApproveRegisterCredentials($approve_param);

	/**
	 * get user from Authorization header
	 */
	public function getAuthenticatedUser();
}
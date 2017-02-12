<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAuthenticate;
use App\Http\Requests\AuthRegister;
use App\Repositories\Users\UserRepository;
use App\Services\Auth\AuthLogic;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user_repository;

    /**
     * @var AuthLogic
     */
    protected $auth_logic;

    public function __construct(UserRepository $user, AuthLogic $auth)
    {
        $this->user_repository = $user;
        $this->auth_logic = $auth;
    }

    /**
     * create access token with user data
     *
     * @param App\Http\Requests\AuthAuthenticate $request
     * @return string
     */
    public function authenticate(AuthAuthenticate $request)
    {     
        $custom_claims = $this->user_repository->getByEmail($request['email']);
        $token = $this->auth_logic->getToken(['email'=>$request['email'], 'password'=>$request['password']], $custom_claims); 
        return response()->json($token);     
    }

    /**
     * save user data to DB and make url for authorization approve
     *
     * @param App\Http\Requests\AuthRegister $request
     * @return string
     */
    public function register(AuthRegister $request)
    {
        $user = $this->user_repository->save($request);
        $approve_param = $this->auth_logic->createApproveRegisterParam(['email'=>$user->email, 'password'=>$user->password]);
        return response()->json(route('register-approve').'/'.$approve_param);
    }

    /**
     * approve user authorization by hash param from email
     *
     * @param string $approve_param
     * @return string
     */
    public function registerApprove($approve_param)
    {
        $credentails = $this->auth_logic->getApproveRegisterCredentials($approve_param);
        
        if(isset($credentails['email']) and isset($credentails['password']) ){
            if($this->user_repository->confirm($credentails)){
                return response()->json('confirm ok'); 
            }
        }

        return response()->json('confirm registration error', 500);         
    }
}

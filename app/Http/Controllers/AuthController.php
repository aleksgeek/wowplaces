<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAuthenticate;
use App\Http\Requests\AuthRegister;
use App\Repositories\Users\UserRepository;
use App\Services\Auth\AuthLogic;
use Illuminate\Mail\Mailer;
use Illuminate\Cache\CacheManager;

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

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var CacheManager
     */
    protected $cache;

    public function __construct(UserRepository $user, AuthLogic $auth, Mailer $mail, CacheManager $cache)
    {
        $this->user_repository = $user;
        $this->auth_logic = $auth;
        $this->mailer = $mail;
        $this->cache  = $cache;
    }

    /**
     * create access token with user data
     *
     * @param App\Http\Requests\AuthAuthenticate $request
     * @return string
     *
     * @throws AuthorizationException
     */
    public function authenticate(AuthAuthenticate $request)
    {         
        try{
            $custom_claims = $this->user_repository->getByEmail($request['email']);
            $token = $this->auth_logic->getToken(['email'=>$request['email'], 'password'=>$request['password']], $custom_claims);

            return response()->json($token); 
        }catch(AuthorizationException $e){
            return response()->json('invalid credentials', $e->getCode());
        }         
    }

    /**
     * save user data to DB and save to cache string for registration approve
     *
     * @param App\Http\Requests\AuthRegister $request
     * @return string
     */
    public function register(AuthRegister $request)
    {
        $user = $this->user_repository->save($request);
        $approve_param = $this->auth_logic->createApproveRegisterParam(['email'=>$user->email, 'password'=>$user->password]);
        
        $this->cache->put('approve_param_'.$user->email, $approve_param, 60);
        
        return response()->json('user was successfuly created');
    }

    /**
     * send mail for registration approve to autor with post params
     *
     * @param App\Http\Requests\AuthRegister $request
     * @return string
     */
    public function sendRegisterApproveMail(Request $request)
    {
        $recipient_email = $request->input('recipient_email'); 
        $approve_param   = $this->cache->get('approve_param_'.$recipient_email);
        $approve_url     = route('register-approve', ['approve_param'=>$approve_param]); 

        $this->mailer->send('emails.register_approve', ['url'=>$approve_url], function ($m) {
            $m->to($recipient_email);
        });

        if($this->mailer->failures()){
            return response()->json('register mail send error', 500);       
        }else{
            return response()->json('register mail was sent'); 
        }          
    }

    /**
     * approve user authorization by hash param from email
     *
     * @param string $approve_param
     * @return string
     *
     * @throws AuthorizationException
     */
    public function registerApprove($approve_param)
    { 
        try{
            $credentails = $this->auth_logic->getApproveRegisterCredentials($approve_param);
            
            if(isset($credentails['email']) and isset($credentails['password'])){
                if($this->user_repository->confirm($credentails)){
                    return response()->json('confirm ok'); 
                }
            }

            return response()->json('confirm registration error', 500);
        }catch(AuthorizationException $e){
            return response()->json('confirm registration error', $e->getCode());
        } 
    }
}

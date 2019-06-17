<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAuthenticate;
use App\Http\Requests\AuthRegister;
use App\Repositories\Users\UserRepository;
use App\Services\Auth\AuthLogic;
use Illuminate\Mail\Mailer;
use Illuminate\Cache\CacheManager;
use Lang;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var AuthLogic
     */
    protected $authLogic;

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
        $this->userRepository = $user;
        $this->authLogic = $auth;
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
     * @throws ModelNotFoundException
     */
    public function authenticate(AuthAuthenticate $request)
    {
        try{
            $user  = $this->userRepository->getByEmail($request->email, 1);
            $token = $this->authLogic->getToken(['email'=>$request->email, 'password'=>$request->password], $user);
            
            setcookie("token", $token, 0, '/', '', 0, 1);
            
            return response()->json($token);
        }catch(AuthorizationException $e){
            return response()->json(Lang::get('messages.error.invalid_credentials'), $e->getCode());
        }catch(ModelNotFoundException $e){
            return response()->json(Lang::get('messages.error.default_error'), $e->getCode());
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
        $user = $this->userRepository->createFromRequest($request);
        $approveParam = $this->authLogic->createApproveRegisterParam([
            'email' => $user->email, 
            'password' => $user->password
        ]);
        
        $this->cache->put('approve_param_'.$user->email, $approveParam, 300);
        
        return response()->json($user);
    }

    /**
     * send mail for registration approve to autor with post params
     *
     * @param App\Http\Requests\AuthRegister $request
     * @return string
     */
    public function sendRegisterApproveMail(Request $request)
    {
        $recipientEmail = $request->input('recipient_email'); 
        $approveParam   = $this->cache->get('approve_param_'.$recipientEmail);
        $approveUrl     = route('register-approve', ['approve_param'=>$approveParam]);

        /// TODO change this on mail functionality
        return response()->json($approveUrl);
        
        /*
        $this->mailer->send('emails.register-approve', ['url'=>$approveUrl], function ($m) {
            $m->to($recipientEmail);
        });

        if($this->mailer->failures()){
            return response()->json('register mail send error', 500);       
        }else{
            return response()->json('register mail was sent'); 
        }
        */
    }

    /**
     * approve user authorization by hash param from email
     *
     * @param string $approveParam
     * @return string
     *
     * @throws AuthorizationException
     */
    public function registerApprove($approveParam)
    { 
        try{
            $credentails = $this->authLogic->getApproveRegisterCredentials($approveParam);
            
            if(isset($credentails['email']) and isset($credentails['password'])){
                if($this->userRepository->confirm($credentails)){
                    return response()->json('confirm ok'); 
                }
            }

            return response()->json('confirm registration error', 500);
        }catch(AuthorizationException $e){
            return response()->json('confirm registration error', $e->getCode());
        } 
    }
}

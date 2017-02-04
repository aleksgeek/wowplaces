<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;

class MailController extends Controller
{
    /**
     * @var Mailer
     */
    protected $mailer;

    public function __construct(Mailer $mail)
    {
        $this->mailer = $mail;
    }

    public function sendMail(Request $request)
    {
        $mail_txt  = $request->input('mail_txt');  
        $recipient = $request->input('recipient');  
        
        $this->mailer->raw($mail_txt, function ($m) {
            $m->to($recipient);
        });

        if($this->mailer->failures()){
            return response()->json('mail send error', 500);       
        }else{
            return response()->json('mail send'); 
        }     
    }
}

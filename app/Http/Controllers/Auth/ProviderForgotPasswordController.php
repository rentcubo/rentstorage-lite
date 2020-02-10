<?php


namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Password;

use DB, Auth, Hash, Validator, Exception;

class ProviderForgotPasswordController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:provider');
    }

    public function showLinkRequestForm() {

        try{

            if( envfile('MAIL_USERNAME') == "" || envfile('MAIL_PASSWORD') == "" ) {

                throw new Exception(tr('email_not_configured_admin'), 101);
                
            }

            return view('provider.auth.passwords.email');

        } catch(Exception $e){ 

            $error = $e->getMessage();

            return redirect()->route('provider.login')->with('error', $error);

        } 
    }

    protected function broker() {

        return Password::broker('providers');
    }

    public function sendPasswordResetNotification($token)
    {   

        if( envfile('MAIL_USERNAME') == "" || envfile('MAIL_PASSWORD') == "" ) {

            throw new Exception(tr('email_not_configured_admin'), 101);
            
        }
        $this->notify(new App\Notifications\CustomResetPasswordNotification($token));
    }

}

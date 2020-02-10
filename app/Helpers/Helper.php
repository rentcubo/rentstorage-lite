<?php 

namespace App\Helpers;

use Hash, Exception, Auth, Mail, File, Log, Storage, Setting, DB;

use App\Admin, App\User, App\Provider;

use App\Category, App\Settings, App\StaticPage;

class Helper {
	
    
    // Note: $error is passed by reference
    
    public static function is_token_valid($entity, $id, $token, &$error) {

        if (
            ( $entity== USER && ($row = User::where('id', '=', $id)->where('token', '=', $token)->first()) ) ||
            ( $entity== PROVIDER && ($row = Provider::where('id', '=', $id)->where('token', '=', $token)->first()) )
        ) {

            if ($row->token_expiry > time()) {
                // Token is valid
                $error = NULL;
                return true;
            } else {
                $error = ['success' => false, 'error' => Helper::error_message(1003), 'error_code' => 1003];
                return FALSE;
            }
        }

        $error = ['success' => false, 'error' => Helper::error_message(1004), 'error_code' => 1004];
        return FALSE;
   
    }

    public static function generate_email_code($value = "") {

        return uniqid($value);
    }

    public static function generate_email_expiry() {

        $token_expiry = Setting::get('token_expiry_hour') ?: 1;
            
        return time() + $token_expiry*3600;  // 1 Hour

    }

    // Check whether email verification code and expiry

    public static function check_email_verification($verification_code , $user_id , &$error,$common) {

        if(!$user_id) {

            $error = tr('user_id_empty');

            return FALSE;

        } else {

            if($common == USER) {
                $user_details = User::find($user_id);
            } else if($common == PROVIDER) {
                $user_details = Provider::find($user_id);
            }
        }

        // Check the data exists

        if($user_details) {

            // Check whether verification code is empty or not

            if($verification_code) {

                // Log::info("Verification Code".$verification_code);

                // Log::info("Verification Code".$user_details->verification_code);

                if ($verification_code ===  $user_details->verification_code ) {

                    // Token is valid

                    $error = NULL;

                    // Log::info("Verification CODE MATCHED");

                    return true;

                } else {

                    $error = tr('verification_code_mismatched');

                    // Log::info(print_r($error,true));

                    return FALSE;
                }

            }
                
            // Check whether verification code expiry 

            if ($user_details->verification_code_expiry > time()) {

                // Token is valid

                $error = NULL;

                Log::info(tr('token_expiry'));

                return true;

            } else if($user_details->verification_code_expiry < time() || (!$user_details->verification_code || !$user_details->verification_code_expiry) ) {

                $user_details->verification_code = Helper::generate_email_code();
                
                $user_details->verification_code_expiry = Helper::generate_email_expiry();
                
                $user_details->save();

                // If code expired means send mail to that user

                $subject = tr('verification_code_title');
                $email_data = $user_details;
                $page = "emails.welcome";
                $email = $user_details->email;
                $result = Helper::send_email($page,$subject,$email,$email_data);

                $error = tr('verification_code_expired');

                Log::info(print_r($error,true));

                return FALSE;
            }
       
        }

    }
    
    public static function generate_password() {

        $new_password = time();
        $new_password .= rand();
        $new_password = sha1($new_password);
        $new_password = substr($new_password,0,8);
        return $new_password;
    }

    public static function file_name() {

        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);

        return $file_name;    
    }

    public static function upload_file($picture , $folder_path = COMMON_FILE_PATH) {

        $file_path_url = "";

        $file_name = Helper::file_name();

        $ext = $picture->getClientOriginalExtension();

        $local_url = $file_name . "." . $ext;

        $inputFile = base_path('public'.$folder_path.$local_url);

        $picture->move(public_path().$folder_path, $local_url);

        $file_path_url = Helper::web_url().$folder_path.$local_url;

        return $file_path_url;
    
    }

    public static function web_url() 
    {
        return url('/');
    }
    
    public static function delete_file($picture, $path = COMMON_FILE_PATH) {

        if ( file_exists( public_path() . $path . basename($picture))) {

            File::delete( public_path() . $path . basename($picture));
      
        } else {

            return false;
        }  

        return true;    
    }
 
    public static function send_email($page,$subject,$email,$email_data) {

        // Check the email configuration 

        if(Setting::get('email_notification') == OFF) {
            
            return Helper::get_error_message(123);
        }

        // check the email configured

        if( config('mail.username') &&  config('mail.password')) {

            try {

                $site_url = url('/');

                $isValid = 1;

                if(envfile('MAIL_DRIVER') == 'mailgun' && Setting::get('MAILGUN_PUBLIC_KEY') && Setting::get('is_mailgun_check_email') == 1) {
                
                    Log::info("isValid - STRAT");

                    # Instantiate the client.

                    $email_address = new Mailgun(Setting::get('MAILGUN_PUBLIC_KEY'));

                    $validateAddress = $email;
                    
                    # Issue the call to the client.
                    $result = $email_address->get("address/validate", array('address' => $validateAddress));

                    # is_valid is 0 or 1

                    $isValid = $result->http_response_body->is_valid;
                    
                    Log::info("isValid FINAL STATUS - ".$isValid);

                }

                if($isValid) {

                    $content = "";

                    $template = [];

                    if(isset($email_data['template_type'])) {
                        
                        $template = EmailTemplate::where('template_type', $email_data['template_type'])->first();
                    }

                    if ($template) {

                        $content = $template->description;

                        $subject = $template->subject ?  str_replace('<%site_name%>', Setting::get('site_name'),$template->subject) : '';

                        $subject = $subject ?  str_replace('&lt;%site_name%&gt;', Setting::get('site_name'),$subject) : '';


                        $content = isset($email_data['email']) ? str_replace('<%email%>',$email_data['email'], $content) : $content;

                        $content = isset($email_data['email']) ? str_replace('&lt;%email%&gt;',$email_data['email'], $content) : $content;

                        $content = isset($email_data['password']) ? str_replace('<%password%>',$email_data['password'],$content) : $content;

                        $content = isset($email_data['password']) ? str_replace('&lt;%password%&gt;',$email_data['password'],$content) : $content;

                        $content = str_replace('<%site_name%>', Setting::get('site_name'),$content);

                        $content = str_replace('&lt;%site_name%&gt;',Setting::get('site_name'),$content);

                    }
                    
                    Log::info(print_r($email_data , true));

                    $email_data['content'] = $content;

                    if (Mail::queue($page, array('email_data' => $email_data,'site_url' => $site_url), 
                            function ($message) use ($email, $subject) {

                                 $message->to($email)->subject($subject);
                            }
                    )) {

                        return Helper::get_message(106);

                    } else {

                        throw new Exception(Helper::get_error_message(123));
                        
                    }

                } else {

                    return Helper::get_message(106);

                }

            } catch(\Exception $e) {

                Log::info($e->getMessage());
                
                return $e->getMessage();

            }

        } else {

            return Helper::get_error_message(123);

        }
    }
      
    // Convert all NULL values to empty strings
    public static function null_safe($input_array) {
 
        $new_array = [];

        foreach ($input_array as $key => $value) {

            $new_array[$key] = ($value == NULL) ? "" : $value;
        }

        return $new_array;
    }
    
    /**
     * @method settings_generate_json()
     *
     * @uses used to update settings.json file with updated details.
     *
     * @created vidhya
     * 
     * @updated vidhya
     *
     * @param -
     *
     * @return boolean
     */
    
    public static function settings_generate_json() {

        $basic_keys = ['site_name', 'site_logo', 'site_icon', 'currency', 'currency_code', 'google_analytics', 'header_scripts', 'body_scripts', 'facebook_link', 'linkedin_link', 'twitter_link', 'google_plus_link', 'pinterest_link', 'demo_user_email', 'demo_user_password', 'demo_provider_email', 'demo_provider_password', 'chat_socket_url', 'google_api_key'];

        $settings = Settings::whereIn('key', $basic_keys)->get();

        $sample_data = [];

        foreach ($settings as $key => $setting_details) {

            $sample_data[$setting_details->key] = $setting_details->value;
        }
        // Social logins

        $social_login_keys = ['FB_CLIENT_ID', 'FB_CLIENT_SECRET', 'FB_CALL_BACK' , 'TWITTER_CLIENT_ID', 'TWITTER_CLIENT_SECRET', 'TWITTER_CALL_BACK', 'GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET', 'GOOGLE_CALL_BACK'];

        $social_logins = Settings::whereIn('key', $social_login_keys)->get();

        $social_login_data = [];

        foreach ($social_logins as $key => $social_login_details) {

            $social_login_data[$social_login_details->key] = $social_login_details->value;
        }

        $sample_data['social_logins'] = $social_login_data;

        $data['data'] = $sample_data;

        $data = json_encode($data);

        $file_name = public_path('/default-json/settings.json');

        File::put($file_name, $data);
    }

    /**
     * @method generate_token()
     * 
     * @uses To genearate token
     *
     * @created Anjana H
     *
     * @updated Anjana H
     *
     * @param Null
     *
     * @return token string
     *
     */
    public static function generate_token() {
        
        return Helper::clean(Hash::make(rand() . time() . rand()));
    }

    /**
     * @method generate_token_expiry()
     * 
     * @uses To genearate token expiry
     *
     * @created Anjana H
     *
     * @updated Anjana H
     *
     * @param Null
     *
     * @return token string
     *
     */
    public static function generate_token_expiry() {

        // dd('test');
        
        $token_expiry_hour = Settings::where('key','token_expiry_hour')->select('value')->get()->toArray() ?: 1;
        
        return time() + $token_expiry_hour[0]['value']*3600;  // 1 Hour
    }

    public static function error_message($code, $other_key = "") {

        switch($code) {
            case 001 :
                $string = tr('invalid_input');
                break;
            case 002 :
                $string = tr('email_already_use');
                break;
            case 003 :
                $string = tr('went_wrong');
                break;
            case 102:
                $string = tr('email_already_use');
                break;
            case 103:
                $string = tr('token_expiry');
                break;
            case 104:
                $string = tr('invalid_token');
                break;
            case 105:
                $string = tr('invalid_email_password');
                break;
            case 106:
                $string = tr('all_fields_required');
                break;
            case 107:
                $string = tr('current_password_incorrect');
                break;
            case 108:
                $string = tr('password_do_not_match');
                break;
            case 109:
                $string = tr('account_verify');
                break;
            case 111:
                $string = tr('email_not_activated');
                break;
            case 131:
                $string = tr('old_password_doesnot_match');
                break;
            case 146:
                $string = tr('something_went_wrong');
                break;
            
            case 163:
                $string = tr('user_payment_details_not_found');
                break;

            case 174:
                $string = tr('card_add_failed');
                break; 

            case 175:
                $string = tr('failed_to_upload');
                break;

            case 502:
                $string = tr('user_account_declined_by_admin');
                break;
            case 503:
                $string = tr('user_account_email_not_verified');
                break;
            case 504:
                $string = tr('id_token_required');
                break;
            case 505:
                $string = tr('user_details_not_found');
                break;
            
            case 901:
                $string = tr('default_card_not_available');
                break;
            case 902:
                $string = tr('something_went_wrong_error_payment');
                break;
            case 903:
                $string = tr('payment_not_completed_pay_again');
                break;
             case 904:
                $string = tr('you_are_not_authroized_person');
                break;
                    
            default:
                $string = tr('unknown_error');
                break;
        }
        return $string;
        
    }

    public static function success_messages($code, $other_key = "") {

        switch($code) {

            case 101:
                $string = tr('success');
                break;
            case 102:
                $string = tr('password_change_success');
                break;
            case 103:
                $string = tr('successfully_logged_in');
                break;
            case 104:
                $string = tr('successfully_logged_out');
                break;
            case 105:
                $string = tr('successfully_sign_up');
                break;
            case 106:
                $string = tr('mail_sent_successfully');
                break;
           
            case 108:
                $string = tr('favourite_provider_delete');
                break;
            case 109:
                $string = tr('payment_mode_changed');
                break;
            case 110:
                $string = tr('payment_mode_changed');
                break;
            case 111:
                $string = tr('service_accepted');
                break;
            case 112:
                $string = tr('provider_started');
                break;
            case 113:
                $string = tr('arrived_service_location');
                break;
            case 114:
                $string = tr('service_started');
                break;
            case 115:
                $string = tr('service_completed');
                break;
            case 116:
                $string = tr('user_rating_done');
                break;
            case 117:
                $string = tr('request_cancelled_successfully');
                break;
            case 118:
                $string = tr('wishlist_added');
                break;
            case 119:
                $string = tr('payment_confirmed_successfully');
                break;
            case 120:
                $string = tr('history_added');
                break;
            case 121:
                $string = tr('history_deleted_successfully');
                break;
            case 122 :
                $string = tr('success_un_followed');

                break;

            case 123 :

                $string = tr('success_followed');

                break;

            default:
                $string = "";
        
        }
        
        return $string;
    }

	/**
	 * @method clean()
	 * 
	 * @uses To replace spaces in string with '-'
	 *
	 * @created Anjana H
	 *
	 * @updated Anjana H
	 *
	 * @param string
	 *
	 * @return string
	 *
	 */
	public static function clean($string) {

	    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

}



    


    
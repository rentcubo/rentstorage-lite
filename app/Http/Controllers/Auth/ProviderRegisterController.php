<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use App\Provider;

use Auth;

class ProviderRegisterController extends Controller
{
    public function __construct() {

        $this->middleware('guest:provider');
    }

    public function showRegisterForm() {

      	return view('provider.auth.register');
    }
    
    public function register(Request $request) {

      try {

      	$this->validate($request, [

          'name'=>'required|min:3|max:100|regex:/^[a-z A-Z]+$/',
      		'mobile' => 'required|digits_between:4,16',
      		'email'=>'required|email|unique:providers,email',
      		'password'=>'required|min:6|confirmed',
      	]);

        $provider_details = New Provider;

        $provider_details->name = $request->name;

      	$provider_details->email = $request->email;

      	$provider_details->mobile = $request->mobile;

      	$provider_details->password = Hash::make($request->password);

        $provider_details->timezone = $request->timezone;

        $provider_details->save();


        if (Auth::guard('provider')->attempt(['email' => $request->email,'password' => $request->password], $request->remember)) {

          return redirect()->intended(route('provider.login'))->with('success',tr('registration_success'));
        }
        
      } catch (Exception $e) {

        DB::rollback();

        return redirect()->back()->withInput()->with('error', $e->getMessage());
        
      }
       
    }
}

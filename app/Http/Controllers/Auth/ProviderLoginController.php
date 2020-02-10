<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Authenticatable;

use Auth;


class ProviderLoginController extends Controller 
{
     public function __construct() {

        $this->middleware('guest:provider', ['except' => ['logout']]);

    }
      
    public function showLoginForm() {

      	return view('provider.auth.login');
    }

    public function login(Request $request) {

      	$this->validate($request, [

      		'email'=>'required|email',
      		'password'=>'required|min:6'
      	]);

      	if (Auth::guard('provider')->attempt(['email' => $request->email,'password' => $request->password], $request->remember)) {

      		return redirect()->intended(route('provider.index'))->with('success',tr('login_success'));

      	}

      	return redirect()->back()->withInput()->with("error",tr('login_error'));
       
    }

    public function logout() {

        Auth::guard('provider')->logout();
        
        return redirect()->route('provider.login');
    }

   
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function GoogleLogin(Request $request){
       
    	$checkUser = User::where('uid',$request->uid)->first();

    	if($checkUser){
    		$checkUser->name = $request->displayName;    
    		$checkUser->email = $request->_email;
            $checkUser->uid = $request->uid;
    		$checkUser->save();
    		Auth::loginUsingId($checkUser->id, true);
    		response()->json([
    			"status" => "success"
            ]);
            if("status" == "success")
            {
                return Redirect::to('/');
            }
            else{
                return Redirect::to('/login');
            }
            

    	}else{
    		$user = new User;
    		
    		$user->name = $request->displayName;    
    		$user->email = $request->_email;
            $user->uid = $request->uid;
            $user->user_type = "google";
    	//var_dump($user);    
    
    		$user->save();
    		Auth::loginUsingId($user->id, true);
    		response()->json([
    			"status" => "success"
    		]);
            if("status" == "success")
            {
                return Redirect::to('/');
            }
            else{
                return Redirect::to('/login');
            }

    }
}
}

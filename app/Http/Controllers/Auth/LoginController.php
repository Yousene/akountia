<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

    protected $loginPath = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge( $request->only($this->username(), 'password'),
        ['confirmation_token' => null, 'validated' => 1]);
    }

    public function username()
    {
        return 'login';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // not admin
        if($user->role === null){
            Auth::logout();
        }
        else{
            \App\User::storeUserData();
            if(auth()->user()->role == '6' )
            {
                return redirect(RouteServiceProvider::HOME_COMMERCIAL);
            }
            elseif(auth()->user()->role == '5' || auth()->user()->role == '7' || auth()->user()->role == '8')
            {
                return redirect(RouteServiceProvider::HOME_PILOTAGE);
            }
            elseif(auth()->user()->role == '2')
            {
                return redirect(RouteServiceProvider::HOME_CLIENT_REVIEW);
            }
            elseif(auth()->user()->role == '3'){
                return redirect(RouteServiceProvider::HOME_Client);
            }
            else{
                return redirect(RouteServiceProvider::HOME);
            }
        }
    }
}

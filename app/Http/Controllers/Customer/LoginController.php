<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/customer-dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    public function showLoginForm()
    {
        if(Auth::guard('customer')->check()){

            return redirect()->route('customer.dashboard');

        }
        return view('customer.login');
    }

    public function guard()
    {
        return Auth::guard('customer');
    }

    public function username()
    {
        return 'email';
    }

    public function logout()
    {
        $this->guard('customer')->logout();
        session()->flash('message', 'Just Logged Out!');
        return redirect('/customer');
    }

}

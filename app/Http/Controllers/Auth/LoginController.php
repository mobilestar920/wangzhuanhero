<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function show_login_form()
    {
        return view('auth.login');
    }
    
    public function process_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        $user = User::where('username', $request->username)->first();
        if ($user != null && $user->is_blocked == 1) {
            session()->flash('message', 'You are banned by admin');
            return redirect()->back();
        } else if ($user == null) {
            $user = User::where('email', $request->username)->first();
            if ($user != null && $user->is_blocked == 1) {
                session()->flash('message', 'You are banned by admin');
                return redirect()->back();
            } else if ($user == null) {
                session()->flash('message', 'Username is not existed.');
                return redirect()->back();
            } else {
                $credentials = $request->only('email', 'password');
            }
        }

        $remember = $request->has('remember') ? true : false;
        
        if (Auth::attempt($credentials, $remember)) {
            if ($user->role == 0) {
                return redirect()->route('sellers');
            } else {
                return redirect()->route('verifyCodes');
            }
        } else {
            session()->flash('message', 'Invalid credentials');
            return redirect()->back();
        }
    }

    public function show_signup_form()
    {
        return view('auth.register');
    }

    public function process_signup(Request $request)
    {   
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
 
        $user = User::create([
            'email' => strtolower($request->input('email')),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        ]);

        session()->flash('message', 'Your account is created');
       
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}

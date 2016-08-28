<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;
use Laraspace\User;
use Laraspace\Http\Requests;
use Auth;


class AuthController extends Controller
{
    public function login()
    {
        return view('admin.sessions.login');
    }

    public function postLogin(Requests\LoginRequest $request)
    {
        if(User::login($request))
        {
            flash()->success('Welcome to FCG-CRM.');
            return redirect()->to('/admin');
        }

        flash()->error('Invalid Login Credentials');
        return redirect()->back();
    }

    public function logOut()
    {
        Auth::logout();
        return redirect()->to('/login');
    }

    /*public function register()
    {
        return view('admin.sessions.register');
    }*/
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(Auth::check()){
            if(Auth::user()->role_id == 1){
                return redirect()->route('admin.dashboard');
            } else if(Auth::user()->role_id == 2){
                return redirect()->route('user.dashboard');
            }
        }
        $viewData = [
            'title' => 'Login',
        ];

        return view('auth.login', $viewData);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role_id == 1){
                return redirect()->route('admin.dashboard');
            } else if(Auth::user()->role_id == 2){
                return redirect()->route('user.dashboard');
            }
        }

        return back()->with(
            'error', 'The provided credentials do not match our records.',
        );
    }
}

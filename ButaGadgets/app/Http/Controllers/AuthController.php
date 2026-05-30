<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $fields = $request->validate([
            'username'=>['required', 'max:255'],
            'email'=>['required', 'max:255', 'email',
            'unique:users'],
            'password'=>['required', 'min:3', 'confirmed']
        ]);

        $user = User::create($fields);
        Auth::login($user);
        return redirect()->route('index');
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'=>['required', 'max:255', 'email',],
            'password'=>['required']
        ]);

        if(Auth::attempt($fields, $request->remember)) {
            return redirect()->intended();
        } else {
            return back()->withErrors([
                'failed'=> 'Невірний логін або пароль'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

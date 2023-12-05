<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        //Auth::attempt($credentials);
        if(Auth::user()->isAdmin($user)){
            return redirect('/admin')
                ->withSuccess('You have successfully created an account');}
        else{
                $request->session()->regenerate();
                return redirect('/homepage')
            ->withSuccess('You have successfully registered & logged in!');
        }
}
}

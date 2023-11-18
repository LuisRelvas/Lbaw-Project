<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{

    public function showLoginForm()
    {
        if (Auth::check()) {
            $isAdmin = DB::table('admin')->where('id', Auth::id())->exists();
            if($isAdmin) {
                return redirect('/admin');
            } else {
                return redirect('/homepage');
            }
        } else {
            return view('auth.login');
        }
    }
    
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $isBlocked = DB::table('blocked')->where('user_id', Auth::id())->exists();
        if($isBlocked) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'This account has been blocked.',
            ])->onlyInput('email');
        }
            $isAdmin = DB::table('admin')->where('id', Auth::id())->exists();
            if($isAdmin) {
                
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/homepage');
            }
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    } 
}

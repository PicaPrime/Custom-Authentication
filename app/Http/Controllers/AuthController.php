<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'nullable|email|exists:users,email|required_without:phone',
            'phone' => 'nullable|exists:users,phone|required_without:email',
            'password' => 'required|min:8',
        ]);
        
        // dd($validated);
        if($validated['email']){
            $user = User::where('email', $validated['email'])->first();
            if($user && password_verify($validated['password'], $user->password )){
                Auth::login($user);
                return redirect(route('dashboard'));
            }
            else{
                return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
            }
        }

        else if($validated['phone']){
            $user = User::where('phone', $validated['phone'])->first();
            if($user && password_verify($validated['password'], $user->password)){
                Auth::login($user);
                return redirect(route('welcome'));
            }
            else{
                return back()->withErrors(['phone' => 'The provided credentials do not match our records.']);
            }
        }

        else {
            return redirect()->route('dashboard');
        }



        

    }


    public function register(Request $request){
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:8',
            'name' => 'required',
        ]);

        // dd($validated);

        $user = User::create($validated);

        return redirect()->route('login')->with('success', 'Registration successful');
    }


    public function logout(Request $request){
       
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }
}

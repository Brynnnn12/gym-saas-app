<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    // Process login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $member = Member::where('email', $credentials['email'])->first();

        if ($member && Hash::check($credentials['password'], $member->password)) {
            session(['member_id' => $member->id]);
            session(['member_name' => $member->name]);
            session(['member_email' => $member->email]);

            return redirect()->intended('/')->with('success', 'Selamat datang, ' . $member->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Show register form
    public function showRegister()
    {
        return view('frontend.auth.register');
    }

    // Process registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $member = Member::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'password' => Hash::make($validated['password']),
        ]);

        session(['member_id' => $member->id]);
        session(['member_name' => $member->name]);
        session(['member_email' => $member->email]);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang, ' . $member->name . '!');
    }

    // Logout
    public function logout()
    {
        session()->forget(['member_id', 'member_name', 'member_email']);
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}

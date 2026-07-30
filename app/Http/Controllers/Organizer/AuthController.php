<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('organizer.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'organizer_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'organizer',
        ]);

        Organizer::create([
            'user_id' => $user->id,
            'name' => $data['organizer_name'],
            'slug' => Str::slug($data['organizer_name']) . '-' . Str::random(5),
            'description' => $data['description'] ?? null,
            'is_approved' => false,
        ]);

        Auth::login($user);

        return redirect()->route('organizer.pending');
    }

    public function showLogin()
    {
        return view('organizer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->isOrganizer()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan akun organizer.']);
            }

            $request->session()->regenerate();

            return $user->organizer && $user->organizer->is_approved
                ? redirect()->route('organizer.dashboard')
                : redirect()->route('organizer.pending');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('organizer.login');
    }

    public function pending()
    {
        return view('organizer.pending');
    }
}
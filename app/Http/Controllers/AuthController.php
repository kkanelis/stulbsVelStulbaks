<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|in:student,teacher',
            'admin_code' => 'nullable|string'
        ]);

        // Determine role. default to student if not provided.
        $role = $data['role'] ?? 'student';

        // Allow creating an admin only when a correct admin code is provided.
        if (!empty($data['admin_code']) && $data['admin_code'] === env('ADMIN_REG_CODE')) {
            $role = 'admin';
        }

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);

        Auth::login($user);

        return $this->redirectToRole($user);
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember')) ) {
            $request->session()->regenerate();
            $user = Auth::user();
            return $this->redirectToRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Redirect user based on role
     */
    private function redirectToRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->intended('/admin');
        }

        if ($user->isTeacher()) {
            return redirect()->intended('/teacher');
        }

        return redirect()->intended('/student');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

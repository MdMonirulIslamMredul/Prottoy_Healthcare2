<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check user role and redirect accordingly
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('superadmin.dashboard')
                    ->with('success', 'Welcome back, Super Admin!');

            case 'divisional_chief':
                return redirect()->route('divisionalchief.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');

            case 'district_manager':
                return redirect()->route('districtmanager.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');

            case 'upazila_supervisor':
                return redirect()->route('upazilasupervisor.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');

            case 'pho':
                return redirect()->route('pho.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');

            case 'customer':
                return redirect()->route('customer.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');

            default:
                return redirect()->route('login')
                    ->with('error', 'No dashboard configured for your role.');
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            $cred = $request->only(["email", "password"]);

            if (Auth::attempt($cred)) {
                // Get the authenticated user
                $user = Auth::user();

                // Check if user has a profile
                $hasProfile = Profile::where('user_id', $user->id)->exists();

                // Redirect based on profile existence
                if ($hasProfile) {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('profile.setup');
                }
            } else {
                return redirect()->route("login")->with("error", "Incorrect Email or Password");
            }
        } catch (Exception $e) {
            return redirect(route("login"))->with("error", $e->getMessage());
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

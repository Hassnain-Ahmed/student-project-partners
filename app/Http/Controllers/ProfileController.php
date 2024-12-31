<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create()
    {
        return view('profile.setup');
    }


    public function update(Request $request)
    {
        $user = auth()->user();
        try {
            $validated = $request->validate([
                'university' => 'required|string',
                'program' => 'required',
                'batch' => 'required',
                'course' => 'required'
            ]);

            $profile = Profile::create([
                'university' => $validated['university'],
                'program' => $validated['program'],
                'batch' => $validated['batch'],
                'course' => $validated['course'],
                'user_id' => $user->id,
            ]);

            if ($profile) {
                return redirect()->route('dashboard')->with("success", "Successfully Completed Profile");
            } else {
                return redirect()->route('profile.setup')->with("error", "Failed to Complete Profile");
            }
        } catch (Exception $e) {
            return redirect()->route('profile.setup')->with("error", $e->getMessage());
        }
    }
}

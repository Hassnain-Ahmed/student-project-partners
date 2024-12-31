<?php

namespace App\Http\Controllers;

use App\Models\ProjectPartnerRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $receivedRequests = collect();
        $partners = collect();
        $userProfiles = collect();

        if ($user) {

            if (method_exists($user, 'receivedRequests')) {
                $receivedRequests = $user->receivedRequests()
                    ->with(['requester', 'course'])
                    ->where('status', 'pending')
                    ->get();
            }

            $partners = ProjectPartnerRequest::where(function ($query) use ($user) {
                $query->where('requester_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
                ->where('status', 'accepted')
                ->with([
                    'requester',
                    'receiver',
                    'course'
                ])
                ->get()
                ->map(function ($partner) {
                    $partner->requester_course = DB::table('profiles')
                        ->where('user_id', $partner->requester_id)
                        ->value('course');

                    $partner->receiver_course = DB::table('profiles')
                        ->where('user_id', $partner->receiver_id)
                        ->value('course');

                    return $partner;
                });

            $course = DB::table("profiles")
                ->select("course")
                ->where("user_id", "=", $user->id)
                ->first();

            if ($course) {
                $userProfiles = DB::table('users')
                    ->join('profiles', 'users.id', '=', 'profiles.user_id')
                    ->select('users.id as user_id', 'users.name', 'profiles.course', 'profiles.program', 'profiles.university', 'profiles.batch')
                    ->where('profiles.course', '=', $course->course)
                    ->where('profiles.user_id', '!=', $user->id)
                    ->get();
            }
        }

        return view('profile.dashboard', compact('receivedRequests', 'partners', 'userProfiles'));
    }
}
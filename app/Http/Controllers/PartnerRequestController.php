<?php

namespace App\Http\Controllers;

use App\Models\ProjectPartnerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PartnerRequestController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'receiver_id' => 'required|exists:users,id'
            ]);

            $user = auth()->user();

            ProjectPartnerRequest::create([
                'requester_id' => $user->id,
                'receiver_id' => $validated['receiver_id'],
                'status' => 'pending'
            ]);

            return back()->with('success', 'Partner request sent successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating partner request: ' . $e->getMessage());
            return back()->with('error', 'Failed to send partner request. Please try again later. |' . $e->getMessage());
        }
    }


    public function accept(ProjectPartnerRequest $request)
    {
        try {
            if ($request->receiver_id !== auth()->id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            DB::transaction(function () use ($request) {
                ProjectPartnerRequest::where('course_id', $request->course_id)
                    ->where('id', '!=', $request->id)
                    ->where(function ($query) use ($request) {
                        $query->where('requester_id', $request->receiver_id)
                            ->orWhere('receiver_id', $request->receiver_id);
                    })
                    ->update(['status' => 'rejected']);

                $request->update(['status' => 'accepted']);
            });

            return back()->with('success', 'Partner request accepted.');
        } catch (\Exception $e) {
            Log::error('Error accepting partner request: ' . $e->getMessage());
            return back()->with('error', 'Failed to accept partner request. Please try again later.');
        }
    }


    public function reject(ProjectPartnerRequest $request)
    {
        try {
            if ($request->receiver_id !== auth()->id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            $request->update(['status' => 'rejected']);

            return back()->with('success', 'Partner request rejected.');
        } catch (\Exception $e) {
            Log::error('Error rejecting partner request: ' . $e->getMessage());
            return back()->with('error', 'Failed to reject partner request. Please try again later.');
        }
    }
}

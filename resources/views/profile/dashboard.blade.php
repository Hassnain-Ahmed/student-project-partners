@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- My Details Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">My Details</h3>
        @php
        $userDetails = DB::table('users')
        ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
        ->select('users.id as user_id', 'users.name', 'profiles.program', 'profiles.course', 'profiles.university', 'profiles.batch')
        ->where('users.id', '=', auth()->user()->id)
        ->first();
        @endphp

        @if($userDetails)
        <div class="space-y-2">
            <p><span class="font-medium text-gray-600">Name:</span> {{ $userDetails->name }}</p>
            <p><span class="font-medium text-gray-600">Program:</span> {{ $userDetails->program }}</p>
            <p><span class="font-medium text-gray-600">Course:</span> {{ $userDetails->course }}</p>
            <p><span class="font-medium text-gray-600">University:</span> {{ $userDetails->university }}</p>
            <p><span class="font-medium text-gray-600">Batch:</span> {{ $userDetails->batch }}</p>
        </div>
        @else
        <p class="text-gray-500">No details available for the current user.</p>
        @endif
    </div>

    <!-- Incoming Requests Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Incoming Partner Requests</h3>
        @forelse($receivedRequests as $request)
        <div class="border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-700">From: {{ $request->requester->name }}</p>
                    <p class="text-sm text-gray-500">Sent: {{ $request->created_at->diffForHumans() }}</p>
                </div>
                <div class="space-x-2">
                    <form action="{{ route('requests.accept', $request->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Accept
                        </button>
                    </form>
                    <form action="{{ route('requests.reject', $request->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-gray-500">No pending partner requests.</p>
        @endforelse
    </div>
</div>

<!-- Current Partners Section -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Your Current Project Partners</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($partners as $partnership)
        <div class="border rounded-lg p-4 bg-gray-50">
            <p class="font-semibold text-gray-700">
                Partner: {{ $partnership->requester_id === auth()->id() 
                                    ? $partnership->receiver->name 
                                    : $partnership->requester->name }}
            </p>
            <p class="text-gray-600">Course: {{ $partnership->receiver_course }}</p>
            <p class="text-sm text-gray-500">Partnered since: {{ $partnership->updated_at->format('M d, Y') }}</p>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">You don't have any project partners yet.</p>
        @endforelse
    </div>
</div>

<!-- Find Partners Section -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Find Project Partners</h3>
    @php
    $availableStudents = DB::table('users')
    ->join('profiles', 'users.id', '=', 'profiles.user_id')
    ->leftJoin('project_partner_requests', function($join) {
    $join->on('users.id', '=', 'project_partner_requests.receiver_id')
    ->orOn('users.id', '=', 'project_partner_requests.requester_id');
    })
    ->where('profiles.course', $userDetails->course)
    ->where('profiles.batch', $userDetails->batch)
    ->where('users.id', '!=', auth()->id())
    ->where(function($query) {
    $query->whereNull('project_partner_requests.status')
    ->orWhereNotIn('project_partner_requests.status', ['pending', 'accepted']);
    })
    ->select('users.id as user_id', 'users.name', 'profiles.program', 'project_partner_requests.status')
    ->distinct()
    ->get();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($availableStudents as $student)
        <div class="border rounded-lg p-4 bg-gray-50">
            <p class="font-semibold text-gray-700">{{ $student->name }}</p>
            <p class="text-gray-600">{{ $student->program }}</p>
            @if($student->status)
            <p class="text-blue-600 text-sm mb-2">Status: {{ ucfirst($student->status) }}</p>
            @endif
            <form action="{{ route('requests.send') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $student->user_id }}">
                <button type="submit"
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded {{ $student->status ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ $student->status ? 'disabled' : '' }}>
                    {{ $student->status ? 'Request Sent' : 'Send Request' }}
                </button>
            </form>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">No available students for partnership in this course.</p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript for the dashboard here
</script>
@endpush
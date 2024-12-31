@extends('layouts.app')

@section('title', 'Complete Profile')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Complete Your Profile</h2>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-6">
            @csrf
            @method('POST')

            <!-- University Name -->
            <div>
                <label for="university" class="block text-sm font-medium text-gray-700 mb-1">University</label>
                <select id="university" name="university" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    <option value="">Select University</option>
                    <option value="Szabist">Szabist</option>
                </select>
                @error('university')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Program -->
            <div>
                <label for="program" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <select id="program" name="program" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    <option value="">Select Your Program</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Accounts and Finance">Accounts and Finance</option>
                    <option value="Robotics">Robotics</option>
                    <option value="Business in Administration">Business in Administration</option>
                </select>
                @error('program')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Batch -->
            <div>
                <label for="batch" class="block text-sm font-medium text-gray-700 mb-1">Select Your Batch</label>
                <select id="batch" name="batch" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    <option value="">Select a batch</option>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}">{{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }} Semester</option>
                        @endfor
                </select>
                @error('batch')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Courses -->
            <div>
                <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Select Your Course</label>
                <select id="course" name="course" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    <option value="">Choose Option</option>
                    <option value="Object Oriented Programming">Object Oriented Programming</option>
                    <option value="Web Technologies">Web Technologies</option>
                    <option value="Parellel and Distribuitive Computing">Parallel and Distributive Computing</option>
                    <option value="Final Year Project">Final Year Project</option>
                </select>
                @error('course')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript for form validation or dynamic behavior here
</script>
@endpush
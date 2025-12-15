@extends('layouts.app')

@section('title', 'Education History - Remoteli')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <x-onboarding-sidebar title="Academic Background" />

        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 w-full max-w-2xl mx-auto">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Step 5 of 6</span>
                    <span class="text-sm font-medium text-blue-600">83%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 83.33%"></div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Education History</h2>
                <p class="text-gray-500">Share your educational qualifications.</p>
            </div>

            <form action="{{ route('onboarding.talent.education-history.store') }}" method="POST" class="space-y-6">
                @csrf

                <div id="educationContainer">
                    <div class="education-entry border-2 border-gray-200 rounded-xl p-6 mb-4">
                        <h4 class="font-semibold text-gray-800 mb-4">Education #1</h4>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Degree/Certification</label>
                                <input type="text" name="education[0][degree]" placeholder="e.g., Bachelor of Science in Computer Science"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Institution Name</label>
                                <input type="text" name="education[0][institution]"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Year</label>
                                    <input type="number" name="education[0][start_year]" min="1950" max="2025"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Year</label>
                                    <input type="number" name="education[0][end_year]" min="1950" max="2030"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                    <label class="flex items-center mt-2">
                                        <input type="checkbox" name="education[0][is_current]" class="mr-2">
                                        <span class="text-sm text-gray-600">Currently studying</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Field of Study</label>
                                <input type="text" name="education[0][field_of_study]"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="addEducation()" class="w-full border-2 border-dashed border-gray-300 text-gray-600 font-semibold py-3 rounded-xl hover:border-blue-500 hover:text-blue-500 transition">
                    + Add Another Education
                </button>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('onboarding.talent.employment-history') }}" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-50 transition text-center">
                        Back
                    </a>
                    <button type="submit" class="flex-1 bg-blue-500 text-white font-semibold py-4 rounded-xl hover:bg-blue-600 transition">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let educationCount = 1;

    function addEducation() {
        const container = document.getElementById('educationContainer');
        const newEntry = `
        <div class="education-entry border-2 border-gray-200 rounded-xl p-6 mb-4">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-semibold text-gray-800">Education #${educationCount + 1}</h4>
                <button type="button" onclick="this.closest('.education-entry').remove()" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Degree/Certification</label>
                    <input type="text" name="education[${educationCount}][degree]" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Institution Name</label>
                    <input type="text" name="education[${educationCount}][institution]" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Year</label>
                        <input type="number" name="education[${educationCount}][start_year]" min="1950" max="2025" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Year</label>
                        <input type="number" name="education[${educationCount}][end_year]" min="1950" max="2030" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <label class="flex items-center mt-2">
                            <input type="checkbox" name="education[${educationCount}][is_current]" class="mr-2">
                            <span class="text-sm text-gray-600">Currently studying</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Field of Study</label>
                    <input type="text" name="education[${educationCount}][field_of_study]" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newEntry);
        educationCount++;
    }
</script>
@endpush
@endsection
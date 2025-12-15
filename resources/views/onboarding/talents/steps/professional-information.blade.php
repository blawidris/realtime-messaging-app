@extends('layouts.app')

@section('title', 'Professional Information - Remoteli')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <x-onboarding-sidebar title="Highlight Your Expertise" />

        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 w-full max-w-2xl mx-auto">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Step 3 of 6</span>
                    <span class="text-sm font-medium text-blue-600">50%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 50%"></div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Professional Information</h2>
                <p class="text-gray-500">Share your skills and professional expertise.</p>
            </div>

            <form action="{{ route('onboarding.talent.professional-information.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Years of Experience -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                    <select name="years_of_experience" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('years_of_experience') border-red-500 @enderror" required>
                        <option value="">Select experience level</option>
                        <option value="0-1" {{ old('years_of_experience') == '0-1' ? 'selected' : '' }}>0-1 years</option>
                        <option value="1-3" {{ old('years_of_experience') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                        <option value="3-5" {{ old('years_of_experience') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                        <option value="5-10" {{ old('years_of_experience') == '5-10' ? 'selected' : '' }}>5-10 years</option>
                        <option value="10+" {{ old('years_of_experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                    </select>
                    @error('years_of_experience')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Primary Skills -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Skills</label>
                    <textarea name="primary_skills" rows="3" placeholder="e.g., JavaScript, React, Node.js, Python (separate with commas)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('primary_skills') border-red-500 @enderror" required>{{ old('primary_skills') }}</textarea>
                    @error('primary_skills')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Industry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Industry</label>
                    <select name="industry" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('industry') border-red-500 @enderror" required>
                        <option value="">Select industry</option>
                        <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Marketing" {{ old('industry') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('industry')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Certifications -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Certifications (Optional)</label>
                    <textarea name="certifications" rows="3" placeholder="List any relevant certifications"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">{{ old('certifications') }}</textarea>
                </div>

                <!-- Languages -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Languages</label>
                    <input type="text" name="languages" value="{{ old('languages') }}" placeholder="e.g., English (Fluent), Spanish (Intermediate)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('languages') border-red-500 @enderror" required>
                    @error('languages')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('onboarding.talent.profile-overview') }}" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-50 transition text-center">
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
@endsection
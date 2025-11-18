@extends('layouts.app')

@section('title', 'Personal Information - Remoteli')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Left Side - Reusable Sidebar -->
        <x-onboarding-sidebar title="Build Your Professional Profile" />

        <!-- Right Side - Form -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 w-full max-w-2xl mx-auto">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Step 1 of 6</span>
                    <span class="text-sm font-medium text-blue-600">16%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 16.66%"></div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Personal Information</h2>
                <p class="text-gray-500">Provide key personal information to establish your identity.</p>
            </div>

            <form action="{{ route('onboarding.talent.personal-information.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('first_name') border-red-500 @enderror" required>
                        @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('last_name') border-red-500 @enderror" required>
                        @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror" required>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone number</label>
                    <div class="flex gap-2">
                        <select name="country_code" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="+233" {{ old('country_code') == '+233' ? 'selected' : '' }}>🇬🇭 +233</option>
                            <option value="+234" {{ old('country_code') == '+234' ? 'selected' : '' }}>🇳🇬 +234</option>
                            <option value="+254" {{ old('country_code') == '+254' ? 'selected' : '' }}>🇰🇪 +254</option>
                            <option value="+27" {{ old('country_code') == '+27' ? 'selected' : '' }}>🇿🇦 +27</option>
                        </select>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('phone') border-red-500 @enderror" required>
                    </div>
                    @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <select name="location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('location') border-red-500 @enderror" required>
                            <option value="">Select location</option>
                            <option value="Ghana" {{ old('location') == 'Ghana' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                            <option value="Nigeria" {{ old('location') == 'Nigeria' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                            <option value="Kenya" {{ old('location') == 'Kenya' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                        </select>
                        @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror" required>
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('onboarding.index') }}" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-50 transition text-center">
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
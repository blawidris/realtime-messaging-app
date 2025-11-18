@extends('layouts.app')

@section('title', 'Profile Overview - Remoteli')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <x-onboarding-sidebar title="Showcase Your Best Self" />

        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 w-full max-w-2xl mx-auto">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Step 2 of 6</span>
                    <span class="text-sm font-medium text-blue-600">33%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 33.33%"></div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Profile Overview</h2>
                <p class="text-gray-500">Tell us about yourself and upload your professional photo.</p>
            </div>

            <form action="{{ route('onboarding.talent.profile-overview.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Profile Photo Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                            <img id="preview" class="w-full h-full object-cover hidden" alt="Preview">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <input type="file" id="photo" name="photo" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <label for="photo" class="cursor-pointer bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition inline-block">
                                Upload Photo
                            </label>
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF (max 2MB)</p>
                        </div>
                    </div>
                    @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Professional Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Professional Title</label>
                    <input type="text" name="professional_title" value="{{ old('professional_title') }}" placeholder="e.g., Senior Software Engineer"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('professional_title') border-red-500 @enderror" required>
                    @error('professional_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Professional Bio</label>
                    <textarea name="bio" rows="5" placeholder="Tell us about your professional background, skills, and what you're passionate about..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('bio') border-red-500 @enderror" required>{{ old('bio') }}</textarea>
                    @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LinkedIn URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn Profile (Optional)</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/yourprofile"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('onboarding.talent.personal-information') }}" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-50 transition text-center">
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
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
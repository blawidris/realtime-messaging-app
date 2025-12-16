@section('title', 'Preferences & Compliance - Remoteli')

<div class="step">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Preferences & Compliance</h2>
        <p class="text-gray-500">Set your job preferences and agree to our terms.</p>
    </div>

    <form id="step6Form" method="POST" class="space-y-6" onsubmit="submitStep(event, 6); return false;">
        @csrf

        <!-- Job Type Preference -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Job Type</label>
            <div class="space-y-2">
                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" name="job_types[]" value="full-time" class="mr-3">
                    <span>Full-time</span>
                </label>
                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" name="job_types[]" value="part-time" class="mr-3">
                    <span>Part-time</span>
                </label>
                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" name="job_types[]" value="contract" class="mr-3">
                    <span>Contract</span>
                </label>
                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" name="job_types[]" value="freelance" class="mr-3">
                    <span>Freelance</span>
                </label>
            </div>
            @error('job_types')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Work Location Preference -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Work Location Preference</label>
            <select name="work_location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('work_location') border-red-500 @enderror" required>
                <option value="">Select preference</option>
                <option value="remote" {{ old('work_location') == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="on-site" {{ old('work_location') == 'on-site' ? 'selected' : '' }}>On-site</option>
                <option value="hybrid" {{ old('work_location') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
            @error('work_location')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Salary Expectation -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Expected Salary Range (USD/year)</label>
            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="salary_min" placeholder="Minimum" value="{{ old('salary_min') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('salary_min') border-red-500 @enderror">
                <input type="number" name="salary_max" placeholder="Maximum" value="{{ old('salary_max') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('salary_max') border-red-500 @enderror">
            </div>
            @error('salary_min')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Availability -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">When can you start?</label>
            <select name="availability" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('availability') border-red-500 @enderror" required>
                <option value="">Select availability</option>
                <option value="immediate" {{ old('availability') == 'immediate' ? 'selected' : '' }}>Immediately</option>
                <option value="2-weeks" {{ old('availability') == '2-weeks' ? 'selected' : '' }}>2 weeks notice</option>
                <option value="1-month" {{ old('availability') == '1-month' ? 'selected' : '' }}>1 month notice</option>
                <option value="2-months" {{ old('availability') == '2-months' ? 'selected' : '' }}>2+ months</option>
            </select>
            @error('availability')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms and Conditions -->
        <div class="border-t pt-6 space-y-4">
            <label class="flex items-start">
                <input type="checkbox" name="agree_terms" class="mt-1 mr-3" required>
                <span class="text-sm text-gray-600">
                    I agree to the <a href="#" class="text-blue-500 hover:underline">Terms of Service</a> and
                    <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a>
                </span>
            </label>

            <label class="flex items-start">
                <input type="checkbox" name="agree_background_check" class="mt-1 mr-3" required>
                <span class="text-sm text-gray-600">
                    I consent to background verification checks as required for employment
                </span>
            </label>

            <label class="flex items-start">
                <input type="checkbox" name="agree_marketing" class="mt-1 mr-3">
                <span class="text-sm text-gray-600">
                    I'd like to receive job alerts and marketing communications (Optional)
                </span>
            </label>
        </div>

        @error('agree_terms')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <div class="flex gap-4 pt-4">
            <x-button type="button" class="w-full max-w-[14rem] border-[#33333333]" variant="outlined" onclick="prevStep()">
                Back
            </x-button>
            <x-button type="submit" class="w-full max-w-xs" variant="primary">
                Complete Registration
            </x-button>
        </div>
    </form>
</div>
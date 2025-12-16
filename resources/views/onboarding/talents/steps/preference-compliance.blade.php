@section('title', 'Preferences & Compliance - Remoteli')

<div
    class="step max-w-4xl mx-auto space-y-10"
    x-data="preferencesForm()">
    {{-- Header --}}
    <div>
        <h2 class="text-3xl font-semibold text-black">
            Preferences and Compliance
        </h2>
        <p class="text-gray-500 mt-1">
            Define your job preferences and ensure alignment with legal and company requirements.
        </p>
    </div>

    <form
        id="step6Form"
        method="POST"
        class="space-y-8"
        @submit.prevent="submitStep(event, 6)">
        @csrf

        <!-- Preferences -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Contract Type -->
            <div>
                <label class="text-sm text-gray-500">
                    Contract Type
                </label>
                <select
                    name="contract_type"
                    x-model="contractType"
                    class="mt-1 w-full px-4 py-3 border rounded-lg">
                    <option value="">Select</option>
                    <option value="full-time">Full-time</option>
                    <option value="part-time">Part-time</option>
                    <option value="contract">Contract</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>

            <!-- Availability -->
            <div>
                <label class="text-sm text-gray-500">
                    Availability
                </label>
                <select
                    name="availability"
                    x-model="availability"
                    class="mt-1 w-full px-4 py-3 border rounded-lg">
                    <option value="">Select</option>
                    <option value="immediate">Immediately</option>
                    <option value="2-weeks">2 weeks notice</option>
                    <option value="1-month">1 month notice</option>
                    <option value="2-months">2+ months</option>
                </select>
            </div>

            <!-- Country -->
            <div>
                <label class="text-sm text-gray-500">
                    Country
                </label>
                <select
                    name="country"
                    x-model="country"
                    class="mt-1 w-full px-4 py-3 border rounded-lg">
                    <option value="">Select</option>
                    <option>Nigeria</option>
                    <option>United Kingdom</option>
                    <option>United States</option>
                    <option>Canada</option>
                </select>
            </div>

            <!-- City -->
            <div>
                <label class="text-sm text-gray-500">
                    City
                </label>
                <input
                    type="text"
                    name="city"
                    x-model="city"
                    class="mt-1 w-full px-4 py-3 border rounded-lg"
                    placeholder="Enter city">
            </div>
        </div>

        <!-- Compliance -->
        <div class="space-y-5 pt-6">

            <label class="flex items-start gap-3">
                <input
                    type="checkbox"
                    name="right_to_work"
                    x-model="rightToWork"
                    class="mt-1">
                <span class="text-sm text-gray-700">
                    I have a right to work in the location above
                </span>
            </label>

            <label class="flex items-start gap-3">
                <input
                    type="checkbox"
                    name="background_check"
                    x-model="backgroundCheck"
                    class="mt-1">
                <span class="text-sm text-gray-700">
                    I consent to background checks
                </span>
            </label>

            <label class="flex items-start gap-3">
                <input
                    type="checkbox"
                    name="agree_terms"
                    x-model="agreeTerms"
                    required
                    class="mt-1">
                <span class="text-sm text-gray-700">
                    I agree to the
                    <a href="#" class="text-primary underline">Terms and Conditions</a>
                    and
                    <a href="#" class="text-primary underline">Privacy Policy</a>
                    outlined by Remoteli.
                </span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-6 pt-8">
            <x-button
                type="button"
                variant="outlined"
                class="w-full max-w-[14rem]"
                onclick="prevStep()">
                Back
            </x-button>

            <x-button
                type="submit"
                variant="primary"
                class="w-full max-w-xs"
                :disabled="!agreeTerms">
                Complete Registration
            </x-button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function preferencesForm() {
        return {
            contractType: '',
            availability: '',
            country: '',
            city: '',
            rightToWork: false,
            backgroundCheck: false,
            agreeTerms: false,
        };
    }
</script>
@endpush
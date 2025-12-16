@section('pageTitle', 'Education History - Remoteli')

<div class="step">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Education History</h2>
        <p class="text-gray-500">Share your educational qualifications.</p>
    </div>

    <form id="step5Form" onsubmit="submitStep(event, 5); return false;" method="POST" class="space-y-6">
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
            <x-button type="button" class="w-full max-w-[14rem] border-[#33333333]" variant="outlined" onclick="prevStep()">
                Back
            </x-button>

            <x-button type="submit" class="w-full max-w-xs" variant="primary">
                Continue
            </x-button>

        </div>
    </form>
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
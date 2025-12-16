@section('pageTitle', 'Education History - Remoteli')

<div
    class="step max-w-5xl mx-auto space-y-10"
    x-data="educationHistory()">
    {{-- Header --}}
    <div>
        <h2 class="text-3xl font-semibold text-black">
            Educational History
        </h2>
        <p class="text-muted text-base sm:text-lg mt-1">
            Showcase your educational achievements and relevant training.
        </p>
    </div>

    <form
        id="step5Form"
        method="POST"
        class="space-y-8"
        @submit.prevent="submitStep(event, 5)">
        @csrf

        <!-- Education entries -->
        <template x-for="(edu, index) in education" :key="index">
            <div class="p-6 space-y-6">

                <!-- Institution -->
                <div>
                    <label class="text-sm text-gray-500">
                        Name of Institution or Website
                    </label>
                    <input
                        type="text"
                        :name="`education[${index}][institution]`"
                        x-model="edu.institution"
                        class="mt-1 w-full px-4 py-3 border rounded-lg">
                </div>

                <!-- Course / Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500">Course</label>

                        <input
                            type="text"
                            :name="`education[${index}][course]`"
                            x-model="edu.course"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">

                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Location</label>
                        <x-ui.location-selector
                            name-prefix="education"
                            index="__INDEX__" />

                        <!-- <select
                            :name="`education[${index}][location]`"
                            x-model="edu.location"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                            <option value="">Select</option>
                            <option>Onsite</option>
                            <option>Remote</option>
                            <option>Hybrid</option>
                        </select> -->
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500">Start Date</label>
                        <input
                            type="month"
                            :name="`education[${index}][start_date]`"
                            x-model="edu.start_date"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">End Date</label>
                        <input
                            type="month"
                            :name="`education[${index}][end_date]`"
                            x-model="edu.end_date"
                            :disabled="edu.current"
                            class="mt-1 w-full px-4 py-3 border rounded-lg disabled:bg-gray-100">

                        <label class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                            <input
                                type="checkbox"
                                :name="`education[${index}][current]`"
                                x-model="edu.current">
                            Studying presently
                        </label>
                    </div>
                </div>

                <!-- Results -->
                <div>
                    <label class="text-sm text-gray-500">Results</label>
                    <select
                        :name="`education[${index}][result]`"
                        x-model="edu.result"
                        class="mt-1 w-full px-4 py-3 border rounded-lg">
                        <option value="">Select</option>
                        <option>First Class</option>
                        <option>Second Class Upper</option>
                        <option>Second Class Lower</option>
                        <option>Pass</option>
                        <option>Distinction</option>
                    </select>
                </div>

                <!-- Remove -->
                <button
                    type="button"
                    x-show="education.length > 1"
                    @click="remove(index)"
                    class="text-red-500 text-sm hover:underline">
                    Remove Education
                </button>
            </div>
        </template>

        <!-- Add new -->
        <button
            type="button"
            @click="add"
            class="flex items-center gap-2 text-primary text-sm font-medium">
            <i class="fa-solid fa-plus"></i>
            Add New Educational History
        </button>

        <!-- Actions -->
        <div class="flex justify-end gap-6 pt-6 w-full">
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
                class="w-full max-w-xs">
                Continue
            </x-button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function educationHistory() {
        return {
            education: [{
                institution: '',
                course: '',
                location: '',
                start_date: '',
                end_date: '',
                current: false,
                result: '',
            }],

            add() {
                this.education.push({
                    institution: '',
                    course: '',
                    location: '',
                    start_date: '',
                    end_date: '',
                    current: false,
                    result: '',
                });
            },

            remove(index) {
                this.education.splice(index, 1);
            },
        };
    }
</script>
@endpush
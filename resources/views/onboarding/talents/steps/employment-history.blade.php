@section('title', 'Employment History - Remoteli')

<div
    class="step mx-auto space-y-10"
    x-data="employmentHistory()">
    {{-- Header --}}
    <div>
        <h2 class="text-3xl font-medium text-black">
            Employment History
        </h2>
        <p class="text-muted mt-1 text-base sm:text-lg">
            Highlight your professional background to match the right opportunities.
        </p>
    </div>

    <form
        id="step4Form"
        method="POST"
        class="space-y-8"
        @submit.prevent="submitStep(event, 4)">
        @csrf

        <!-- Employment entries -->
        <template x-for="(job, index) in jobs" :key="index">
            <div class="p-6 space-y-6">

                <!-- Grid: Role / Contract -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-muted">Role</label>
                        <input
                            type="text"
                            :name="`employment[${index}][role]`"
                            x-model="job.role"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm text-muted">Employment Contract</label>
                        <select
                            :name="`employment[${index}][contract]`"
                            x-model="job.contract"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                            <option value="">Select</option>
                            <option>Full-time</option>
                            <option>Part-time</option>
                            <option>Contract</option>
                            <option>Freelance</option>
                        </select>
                    </div>
                </div>

                <!-- Grid: Company / Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-muted">Company</label>
                        <input
                            type="text"
                            :name="`employment[${index}][company]`"
                            x-model="job.company"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm text-muted">Location</label>
                        <select
                            :name="`employment[${index}][location]`"
                            x-model="job.location"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                            <option value="">Select</option>
                            <option>Remote</option>
                            <option>Onsite</option>
                            <option>Hybrid</option>
                        </select>
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-muted">Start Date</label>
                        <input
                            type="month"
                            :name="`employment[${index}][start_date]`"
                            x-model="job.start_date"
                            class="mt-1 w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm text-muted">End Date</label>
                        <input
                            type="month"
                            :name="`employment[${index}][end_date]`"
                            x-model="job.end_date"
                            :disabled="job.current"
                            class="mt-1 w-full px-4 py-3 border rounded-lg disabled:bg-gray-100">

                        <label class="flex items-center gap-2 mt-2 text-sm text-muted">
                            <input
                                type="checkbox"
                                :name="`employment[${index}][current]`"
                                x-model="job.current">
                            This is my current employer
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="text-sm text-muted">
                        Description and Responsibilities
                    </label>

                    <textarea
                        rows="4"
                        :name="`employment[${index}][description]`"
                        x-model="job.description"
                        placeholder="Enter Text Here..."
                        class="mt-2 w-full px-4 py-3 border rounded-lg resize-none" id="quill-editor"></textarea>

                    <div class="text-right text-xs text-gray-400 mt-1">
                        <span x-text="job.description.length"></span>/200 Characters
                    </div>
                </div>

                <!-- Remove -->
                <button
                    type="button"
                    x-show="jobs.length > 1"
                    @click="remove(index)"
                    class="text-red-500 text-sm hover:underline">
                    Remove Employment
                </button>
            </div>
        </template>

        <!-- Add new -->
        <button
            type="button"
            @click="add"
            class="flex items-center gap-2 text-primary text-sm font-medium">
            <i class="fa-solid fa-plus"></i>
            Add New Employment History
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
    function employmentHistory() {
        return {
            jobs: [{
                role: '',
                contract: '',
                company: '',
                location: '',
                start_date: '',
                end_date: '',
                current: false,
                description: '',
            }],

            add() {
                this.jobs.push({
                    role: '',
                    contract: '',
                    company: '',
                    location: '',
                    start_date: '',
                    end_date: '',
                    current: false,
                    description: '',
                });
            },

            remove(index) {
                this.jobs.splice(index, 1);
            },
        };
    }

    quillEditor();
</script>
@endpush
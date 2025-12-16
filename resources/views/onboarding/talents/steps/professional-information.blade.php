@section('title', 'Professional Information - Remoteli')

<div class="step max-w-5xl mx-auto space-y-10">

    {{-- Header --}}
    <div class="w-full">
        <h2 class="text-3xl font-semibold text-black">
            Professional Information
        </h2>
        <p class="text-muted text-base sm:text-lg mt-2">
            Highlight your desired positions, skills and proficiency.
        </p>
    </div>

    <form
        id="step3Form"
        method="POST"
        class="space-y-8"
        onsubmit="submitStep(event, 3); return false;">
        @csrf

        {{-- Desired Positions --}}
        <div
            x-data="dynamicList({ title: '', experience: '' })"
            class="space-y-4">
            <h3 class="text-sm font-medium text-black">
                Desired Positions
            </h3>

            <template x-for="(item, index) in items" :key="index">
                <div class="border border-[#EBEDF0] rounded-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end px-4 py-5 md:place-items-center">
                    <div class="w-full">
                        <label class="text-xs text-muted">Position</label>
                        <input
                            type="text"
                            :name="`positions[${index}][title]`"
                            x-model="item.title"
                            class="w-full mt-1 px-4 py-3 border rounded-lg focus:ring-0 focus:border-gray-400"
                            placeholder="e.g. Frontend Developer">
                    </div>

                    <div class="w-full">
                        <label class="text-xs text-muted">Experience</label>
                        <select
                            :name="`positions[${index}][experience]`"
                            x-model="item.experience"
                            class="w-full mt-1 px-4 py-3 border rounded-lg">
                            <option value="">Select</option>
                            <option>0–1 years</option>
                            <option>2–4 years</option>
                            <option>5+ years</option>
                        </select>
                    </div>

                    <div class="inline-flex items-center gap-2 py-3">

                        <button
                            type="button"
                            x-show="items.length > 1"
                            @click="remove(index)"
                            class="text-danger text-xl hover:underline w-auto">
                            <i class="bi bi-x"></i>
                        </button>

                        <button
                            type="button"
                            @click="add"
                            class="flex items-center gap-2 text-primary text-sm font-medium">
                            <i class="bi bi-plus"></i>
                            Add Another Position
                        </button>
                    </div>
                </div>
            </template>


        </div>

        {{-- Key Skills --}}
        <div
            x-data="dynamicList({ name: '', experience: '' })"
            class="space-y-4">
            <h3 class="text-sm font-medium text-black">
                Your Key Skills
            </h3>

            <template x-for="(item, index) in items" :key="index">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end px-4 py-5 border border-[#EBEDF0] rounded-xl md:place-items-center">
                    <div class="w-full">
                        <label class="text-xs text-muted">Skill</label>
                        <input
                            type="text"
                            :name="`skills[${index}][name]`"
                            x-model="item.name"
                            class="w-full mt-1 px-4 py-3 border rounded-lg"
                            placeholder="e.g. React">
                    </div>

                    <div class="w-full">
                        <label class="text-xs text-muted">Experience</label>
                        <select
                            :name="`skills[${index}][experience]`"
                            x-model="item.experience"
                            class="w-full mt-1 px-4 py-3 border rounded-lg">
                            <option value="">Select</option>
                            <option>Beginner</option>
                            <option>Intermediate</option>
                            <option>Expert</option>
                        </select>
                    </div>

                    <div class="inline-flex items-center gap-2 py-3">
                        <button
                            type="button"
                            x-show="items.length > 1"
                            @click="remove(index)"
                            class="text-danger text-xl hover:underline w-auto">
                            <i class="bi bi-x"></i>
                        </button>

                        <button
                            type="button"
                            @click="add"
                            class="flex items-center gap-2 text-primary text-sm font-medium">
                            <i class="bi bi-plus"></i>
                            Add Another Skill
                        </button>

                    </div>
                </div>
            </template>


        </div>

        {{-- Software & Tools --}}
        <div
            x-data="{ open: true }"
            class="space-y-4">
            <button
                type="button"
                @click="open = !open"
                class="w-full flex justify-between items-center text-sm font-medium text-black">
                Software and Tools Proficiency
                <i
                    class="bi "
                    :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
            </button>

            <div x-show="open" x-transition>
                <div
                    x-data="dynamicList({ tool: '', level: '' })"
                    class="space-y-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="border border-[#EBEDF0] rounded-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end md:place-items-center p-4">
                            <div class="w-full">
                                <label class="text-xs text-muted">Software or Tool</label>
                                <input
                                    type="text"
                                    :name="`tools[${index}][name]`"
                                    x-model="item.tool"
                                    class="w-full mt-1 px-4 py-3 border rounded-lg">
                            </div>

                            <div class="w-full">
                                <label class="text-xs text-muted">Proficiency</label>
                                <select
                                    :name="`tools[${index}][level]`"
                                    x-model="item.level"
                                    class="w-full mt-1 px-4 py-3 border rounded-lg">
                                    <option value="">Select</option>
                                    <option>Beginner</option>
                                    <option>Intermediate</option>
                                    <option>Advanced</option>
                                </select>
                            </div>

                            <div class="inline-flex items-center gap-2 py-3">

                                <button
                                    type="button"
                                    x-show="items.length > 1"
                                    @click="remove(index)"
                                    class="text-danger text-xl hover:underline w-auto">
                                    <i class="bi bi-x"></i>
                                </button>
                                <button
                                    type="button"
                                    @click="add"
                                    class="flex items-center gap-2 text-primary text-sm font-medium">
                                    <i class="bi bi-plus"></i>
                                    Add Another Skill
                                </button>
                            </div>
                        </div>
                    </template>


                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-6 pt-6">
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

@push("scripts")

<script>
    function dynamicList(template) {
        return {
            items: [{
                ...template
            }],

            add() {
                this.items.push({
                    ...template
                });
            },
            remove(index) {
                this.items.splice(index, 1);
            },
        };
    }
</script>
@endpush
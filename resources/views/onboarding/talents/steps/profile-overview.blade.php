@section('pageTitle', 'Profile Overview - Remoteli')


<div
    class="step max-w-4xl mx-auto"
    x-data="profileOverview()">
    {{-- Header --}}
    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-black">
            Profile Overview
        </h2>
        <p class="text-gray-500 mt-1">
            Upload a profile image, highlight your language skills, and craft a compelling summary about yourself.
        </p>
    </div>

    <form
        method="POST"
        enctype="multipart/form-data"
        class="space-y-10"
        id="step2Form"
        @submit.prevent="submitStep(event, 2)">
        @csrf

        {{-- Profile Photo --}}
        <div class="flex justify-end">
            <div class="relative flex items-center gap-6">
                <!-- Avatar -->
                <div
                    class="relative w-28 h-28 rounded-full border-8 border-gray-100 bg-gray-50 overflow-hidden shadow-sm flex items-center justify-center" @click="$refs.photoInput.click()">
                    <template x-if="photoPreview">
                        <img
                            :src="photoPreview"
                            alt="Profile preview"
                            class="w-full h-full object-cover">
                    </template>

                    <template x-if="!photoPreview">
                        <img
                            src="{{ asset('images/icons/camera.png') }}"
                            alt="Upload"
                            class="w-10 opacity-60">
                    </template>

                    <!-- Upload trigger -->
                    <!-- <button
                        type="button"
                        @click="$refs.photoInput.click()"
                        class="absolute -bottom-2 -right-2 w-full h-full rounded-full bg-white shadow flex items-center justify-center hover:bg-gray-100 transition">
                        <i class="fa-solid fa-camera text-gray-600 text-sm"></i>
                    </button> -->
                </div>

                <!-- Delete button -->
                <button
                    type="button"
                    x-show="photoPreview"
                    x-transition
                    @click="removePhoto"
                    class="px-4 py-2 rounded-lg bg-[#FAFAFA] text-sm text-muted hover:bg-gray-200 transition">
                    Delete
                </button>

                <!-- Hidden input -->
                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                    class="hidden"
                    x-ref="photoInput"
                    @change="handlePhotoUpload">
            </div>
        </div>

        {{-- Short Headline --}}
        <div class="p-5">
            <div class="inline-flex gap-1">
                <label class="text-sm font-medium text-muted">
                    Add a Short Headline
                </label>
                <i class="bi bi-info-circle-fill text-[#B0B0B0]"></i>
            </div>


            <div class="relative border border-[#EBEDF0] rounded-lg px-4 flex flex-col-reverse">
                <span class="text-xs text-muted absolute bottom-2 right-4">
                    <span x-text="headline.length"></span>/50 Characters
                </span>
                <input
                    type="text"
                    name="professional_title"
                    maxlength="50"
                    x-model="headline"
                    placeholder="e.g. Senior Software Engineer"
                    class="w-full border-0 focus:ring-0 outline-0 focus:outline-0 text-black placeholder-muted py-3">
            </div>
        </div>

        {{-- About --}}
        <div class="">
            <div class="inline-flex gap-1 px-5 py-3">
                <label class="text-sm font-medium text-muted">
                    About
                </label>
                <i class="bi bi-info-circle-fill text-[#B0B0B0]"></i>
            </div>

            <div
                x-data="quillEditor()"
                x-init="init()"
                class="p-5 relative">
                <div id="quill-editor" class="min-h-[140px]"></div>
                <input type="hidden" name="bio" x-ref="bio">

                <span class="text-xs text-muted absolute bottom-10 right-8">
                    <span x-text="bioLength"></span>/200 Characters
                </span> 
            </div>
        </div>

        {{-- Languages --}}
        <div
            x-data="languagesForm()"
            class="space-y-4">
            <div class="inline-flex gap-1 px-5 py-3">
                <label class="text-sm font-medium text-muted">
                    Your Language
                </label>
                <i class="bi bi-info-circle-fill text-[#B0B0B0]"></i>
            </div>

            <div class="border border-[#EBEDF0] rounded-lg p-5">

                <template x-for="(lang, index) in languages" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="text-xs text-gray-500">Language</label>
                            <select
                                :name="`languages[${index}][name]`"
                                x-model="lang.name"
                                class="w-full mt-1 px-4 py-3 border rounded-lg focus:ring-0 focus:border-muted">
                                <option value="">Select language</option>
                                <option>English</option>
                                <option>French</option>
                                <option>Spanish</option>
                                <option>German</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500">Proficiency</label>
                            <select
                                :name="`languages[${index}][level]`"
                                x-model="lang.level"
                                class="w-full mt-1 px-4 py-3 border rounded-lg focus:ring-0 focus:border-muted">
                                <option value="">Select level</option>
                                <option>Beginner</option>
                                <option>Intermediate</option>
                                <option>Fluent</option>
                                <option>Native</option>
                            </select>
                        </div>

                        <button
                            type="button"
                            x-show="languages.length > 1"
                            @click="removeLanguage(index)"
                            class="text-red-500 text-sm hover:underline mt-5">
                            Remove
                        </button>
                    </div>
                </template>
            </div>
            <button
                type="button"
                @click="addLanguage"
                class="flex items-center gap-2 text-primary text-sm font-medium">
                <i class="fa-solid fa-plus"></i>
                Add Another Language
            </button>

        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-6 pt-6">
            <x-button type="button" variant="outlined" class="w-full max-w-[14rem]" onclick="prevStep()">
                Back
            </x-button>

            <x-button type="submit" variant="primary" class="w-full max-w-xs">
                Continue
            </x-button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function profileOverview() {
        return {
            photoPreview: null,
            headline: '',
            bioLength: 0,

            handlePhotoUpload(e) {
                const file = e.target.files[0];
                if (!file) return;

                this.photoPreview = URL.createObjectURL(file);
            },

            removePhoto() {
                this.photoPreview = null;
                this.$refs.photoInput.value = null;
            },
        };
    }

    function languagesForm() {
        return {
            languages: [{
                    name: '',
                    level: ''
                }, // default row
            ],

            addLanguage() {
                this.languages.push({
                    name: '',
                    level: ''
                });
            },

            removeLanguage(index) {
                this.languages.splice(index, 1);
            },
        };
    }
</script>

@endpush
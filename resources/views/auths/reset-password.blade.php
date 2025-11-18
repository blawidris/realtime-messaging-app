<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="flex flex-col h-screen ">

        <a href=".." class="inline-flex items-center gap-4 pt-10 pl-5 sm:pl-10 cursor-pointer">
            <div class="rounded-full items-center size-8 flex flex-col justify-center border border-muted">
                <i class="bi bi-arrow-left-short text-3xl text-muted font-medium"></i>
            </div>
            <span>Back</span>
        </a>

        <div class="flex flex-col items-center justify-center h-full -mt-10">
            <div class=" px-5 sm:px-8 lg:px-0 inline-flex sm:items-center sm:justify-center w-full flex-col mb-10">
                <h1 class="text-2xl sm:text-3xl font-bold text-black font-vietnam">Reset Password</h1>
                <p class="text-muted mt-2 sm:text-center">
                    Please type something you will remember.
                </p>
            </div>

            <div class="w-full max-w-xl px-5 sm:px-8 lg:px-0">
                <!-- Form -->
                <form class="mt-8">

                    <!-- Email Field -->
                    <div class="space-y-2 mb-6">
                        <label class="block text-muted mb-1 text-sm">New password</label>
                        <div class="inline-flex items-center w-full">
                            <input
                                type="password"
                                placeholder="New password"
                                class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span id="passwordToggler" class="cursor-pointer"><i class="bi bi-eye-fill text-muted text-base -ml-8"></i></span>

                        </div>
                    </div>

                    <div class="space-y-2 mb-10">
                        <label class="block text-muted mb-1 text-sm">Confirm password</label>
                        <div class="inline-flex items-center w-full">
                            <input
                                type="password"
                                placeholder="Confirm password"
                                class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span id="passwordToggler" class="cursor-pointer"><i class="bi bi-eye-fill text-muted text-base -ml-8"></i></span>
                        </div>
                    </div>

                    <!-- Send code Button -->
                    <button
                        type="submit"
                        class="w-full py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-layouts.app>
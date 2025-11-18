<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="flex flex-col h-screen ">

        <a href=".." class="inline-flex items-center gap-4 pt-10 pl-5 sm:pl-10">
            <div class="rounded-full items-center size-8 flex flex-col justify-center border border-muted">
                <i class="bi bi-arrow-left-short text-3xl text-muted font-medium"></i>
            </div>
            <span>Back</span>
        </a>

        <div class="flex items-center justify-center h-full">

            <div class="w-full max-w-xl px-5 sm:px-8 lg:px-0">

                <div class="inline-flex sm:items-center sm:justify-center w-full flex-col">
                    <h1 class="text-2xl sm:text-3xl font-bold text-black font-vietnam">Please check your mail</h1>
                    <p class="text-muted mt-2 sm:text-center">
                        We’ve sent a code to <span class="text-primary">@gmail.com </span>
                    </p>
                </div>

                <!-- Form -->
                <form class="mt-8 space-y-6">

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="block text-muted mb-1 text-sm">Email address</label>
                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>

                    <!-- Send code Button -->
                    <button
                        onclick="window.location.href = '/reset-password'"
                        type="button"
                        class="w-full py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition">
                        Send Code
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-layouts.app>
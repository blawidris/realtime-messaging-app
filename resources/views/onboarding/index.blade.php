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

        <div class="flex items-center justify-center h-full">

            <div class="w-full max-w-2xl px-5 sm:px-8 lg:px-0">

                <div class="inline-flex sm:items-center sm:justify-center w-full flex-col">
                    <h1 class="text-2xl sm:text-3xl font-bold text-black font-vietnam">Join As A Client Or Candidate</h1>
                    <p class="text-gray-500 mt-2 sm:text-center">
                        Help us tailor your setup by choosing your account type.
                    </p>
                </div>

                <!-- Form -->
                <form class="mt-8 grid sm:grid-cols-2 gap-x-4">

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">First name</label>
                        <input
                            type="text"
                            name="firstname"
                            placeholder="e.g francis"
                            required
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">Last name</label>
                        <input
                            type="text"
                            name="lastname"
                            placeholder="e.g Doe"
                            required
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">Company Name</label>
                        <input
                            type="text"
                            name="company_name"
                            placeholder="e.g Doe"
                            required
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">Country</label>

                        <select name="country" placeholder="e.g United State" id="country" class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option>Select Country</option>
                        </select>
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            placeholder="e.g francis@mail.com"
                            required
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">Company Website</label>
                        <input
                            type="text"
                            name="company_website"
                            placeholder="eg. www.google.com"
                            required
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
                        <label class="block text-muted mb-1 text-sm">Password</label>
                        <div class="inline-flex items-center w-full">
                            <input
                                type="password"
                                placeholder="password"
                                class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span id="passwordToggler" class="cursor-pointer"><i class="bi bi-eye-fill text-muted text-base -ml-8"></i></span>

                        </div>
                    </div>

                    <div class="space-y-2 mb-4 sm:mb-6">
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
                        onclick="window.location.href = '/verify-email'"
                        type="button"
                        class="mt-10 w-full py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition col-span-2">
                        Create Account
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-layouts.app>
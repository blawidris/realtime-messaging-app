<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="flex items-center justify-center h-screen">

        <div class="w-full max-w-xl px-8 lg:px-0">

            <h1 class="text-3xl font-bold text-black font-vietnam">Welcome Back!</h1>
            <p class="text-gray-500 mt-2">
                Log in to continue where you left off. We’re glad to have you here.
            </p>

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

                <!-- Password Field -->
                <div class="space-y-2">
                    <label class="block text-muted mb-1 text-sm">Password</label>
                    <input
                        type="password"
                        placeholder="Enter password"
                        class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>

                <!-- Remember + Forgot Password -->
                <div class="flex items-center justify-between text-sm">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-400">
                        <span class="text-black text-sm">Remember me</span>
                    </label>

                    <a href="/forget-password" class="text-sm text-primary font-medium hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition">
                    Login
                </button>

                <!-- Create Account -->
                <p class="mt-4 text-center text-black text-sm">
                    Don’t have an account?
                    <a href="/signup" class="text-primary font-semibold hover:underline">
                        Create account
                    </a>
                </p>

            </form>
        </div>

    </div>

</x-layouts.app>
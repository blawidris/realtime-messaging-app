<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="w-full lg:w-1/2 bg-white p-6 sm:p-12">
        <a href=".." class="flex items-center space-x-2 text-gray-500 hover:text-gray-800 transition-colors mb-8">
            <div class="rounded-full border border-gray-500 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <span>Back</span>
        </a>
        <div class="flex items-center justify-center h-full">
            <div class="w-full max-w-xl px-5 sm:px-8 lg:px-0">
                <div class="inline-flex sm:items-center sm:justify-center w-full flex-col">
                    <h1 class="text-2xl sm:text-3xl font-bold text-black font-vietnam">Forgot Password?</h1>
                    <p class="text-gray-500 mt-2 sm:text-center">
                        Don't worry! It happens. Please enter the email associated with your account.
                    </p>
                </div>
                <!-- Form -->
                <form id="forgot-password-form" class="mt-8 space-y-6" novalidate>
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-gray-500 mb-1 text-sm">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            placeholder="Enter your email"
                            required
                            class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <p id="email-error" class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <!-- Send code Button -->
                    <button
                        id="send-code-btn"
                        type="submit"
                        disabled
                        class="w-full py-3 bg-gradient-to-r from-[#68A3FF] to-blue-500 text-white rounded-xl font-semibold shadow hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Send Code
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('forgot-password-form');
            const emailInput = document.getElementById('email');
            const sendCodeBtn = document.getElementById('send-code-btn');
            const emailError = document.getElementById('email-error');

            const emailPattern = /^\S+@\S+\.\S+$/;

            function validateEmail() {
                const value = emailInput.value.trim();
                let isValid = true;
                let errorMessage = '';

                if (!value) {
                    isValid = false;
                    errorMessage = 'Email is required.';
                } else if (!emailPattern.test(value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }

                emailError.textContent = errorMessage;
                emailInput.classList.toggle('border-red-500', !isValid);
                emailInput.classList.toggle('focus:ring-red-300', !isValid);

                // Enable or disable button based on validity
                sendCodeBtn.disabled = !isValid;

                return isValid;
            }

            // Validate on input
            emailInput.addEventListener('input', validateEmail);

            // Validate on blur
            emailInput.addEventListener('blur', validateEmail);

            // Handle form submission
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                if (validateEmail()) {
                    console.log('Email submitted:', emailInput.value);
                    // Redirect to verify email page
                    window.location.href = '/verify-email';
                }
            });
        });
    </script>
    @endpush

</x-layouts.app>
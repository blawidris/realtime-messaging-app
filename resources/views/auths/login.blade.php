<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>
    <div class="w-full lg:w-1/2 bg-white p-6 sm:p-12 flex items-center justify-center">
        <div class="w-full max-w-xl px-5 sm:px-8 lg:px-0">
            <div class="text-center flex items-center justify-center flex-col py-6 lg:mb-16">
                <h1 class="text-3xl font-bold text-black font-vietnam">Welcome Back!</h1>
                <p class="text-gray-500 mt-2">
                    Log in to continue where you left off. We’re glad to have you here.
                </p>

            </div>

            <form id="login-form" class="mt-8 space-y-6" novalidate>
                <div>
                    <label for="email" class="block text-muted mb-1 text-sm">Email address</label>
                    <input id="email" name="email" type="email" placeholder="Enter your email" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <p class="text-red-500 text-xs mt-1 h-4"></p>
                </div>

                <div>
                    <label for="password" class="block text-muted mb-1 text-sm">Password</label>
                    <div class="relative flex items-center w-full">
                        <input id="password" name="password" type="password" placeholder="Enter your password" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <span class="password-toggler cursor-pointer absolute right-3"><i class="bi bi-eye-fill text-muted text-base"></i></span>
                    </div>
                    <p class="text-red-500 text-xs mt-1 h-4"></p>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-400 text-primary focus:ring-primary">
                        <span class="text-black text-xs sm:text-sm">Remember me</span>
                    </label>
                    <a href="/forgot-password" class="text-xs sm:text-sm text-primary font-medium hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <button id="login-btn" type="submit" disabled class="w-full py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Login
                </button>

                <p class="mt-4 text-center text-black text-sm">
                    Don’t have an account?
                    <a href="/signup" class="text-primary font-semibold hover:underline">
                        Create account
                    </a>
                </p>
            </form>
        </div>
    </div>

    @push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('login-form');
            const loginButton = document.getElementById('login-btn');
            const inputs = Array.from(loginForm.querySelectorAll('input[required]'));

            const validationRules = {
                email: {
                    required: true,
                    pattern: /^\S+@\S+\.\S+$/,
                    message: 'Please enter a valid email.'
                },
                password: {
                    required: true,
                    message: 'Password is required.'
                },
            };

            function validateInput(input) {
                const rule = validationRules[input.name];
                // FIX: Handle both structures (direct parent and wrapper parent)
                const parentDiv = input.closest('div');
                const errorEl = parentDiv.nextElementSibling;
                let isValid = true;
                let errorMessage = '';

                if (!rule) return true;

                if (rule.required && !input.value.trim()) {
                    isValid = false;
                    errorMessage = rule.message.includes('required') ? rule.message : 'This field is required.';
                } else if (rule.pattern && !rule.pattern.test(input.value)) {
                    isValid = false;
                    errorMessage = rule.message;
                }

                if (errorEl && errorEl.tagName === 'P') {
                    errorEl.textContent = errorMessage;
                }

                input.classList.toggle('border-red-500', !isValid);
                input.classList.toggle('focus:ring-red-300', !isValid);
                return isValid;
            }

            function checkFormValidity() {
                const isFormValid = inputs.every(validateInput);
                loginButton.disabled = !isFormValid;
            }

            loginForm.addEventListener('input', (e) => {
                if (e.target.tagName === 'INPUT') {
                    validateInput(e.target);
                    checkFormValidity();
                }
            });

            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                checkFormValidity();
                if (!loginButton.disabled) {
                    console.log('Login form submitted');
                    // Add login logic here
                    alert('Logged in successfully!');
                }
            });

            // --- PASSWORD TOGGLER ---
            document.querySelectorAll('.password-toggler').forEach(toggler => {
                toggler.addEventListener('click', () => {
                    const input = toggler.previousElementSibling;
                    const icon = toggler.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye-fill');
                        icon.classList.add('bi-eye-slash-fill');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash-fill');
                        icon.classList.add('bi-eye-fill');
                    }
                });
            });
        });
    </script>
    @endpush

</x-layouts.app>
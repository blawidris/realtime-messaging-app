<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="w-full lg:w-1/2 bg-white p-6 sm:p-12">

        <a href=".." class="flex items-center space-x-2 text-gray-500 hover:text-gray-800 transition-colors mb-8">
            <div class="rounded-full border border-gray-500 px-1">
                <i class="bi bi-arrow-left-short text-2xl text-muted font-medium"></i>
            </div>
            <span>Back</span>
        </a>

        <div class=" flex flex-col items-center justify-center">
            <div class="w-full max-w-2xl px-5 sm:px-8 lg:px-0">
                <div class="text-center flex items-center justify-center flex-col py-6 lg:mb-16">
                    <h1 class="text-3xl font-bold text-black font-vietnam">Reset Password</h1>
                    <p class="text-gray-500 mt-2">
                        Please type something you will remember.
                    </p>

                </div>

                <form id="reset-form" class="mt-8" novalidate>
                    <div class="mb-4 sm:mb-6">
                        <label for="password" class="block text-muted mb-1 text-sm">New Password</label>
                        <div class="relative flex items-center w-full">
                            <input type="password" id="password" name="password" placeholder="8+ characters" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span class="password-toggler cursor-pointer absolute right-3"><i class="bi bi-eye-fill text-muted text-base"></i></span>
                        </div>
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label for="confirm_password" class="block text-muted mb-1 text-sm">Confirm password</label>
                        <div class="relative flex items-center w-full">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span class="password-toggler cursor-pointer absolute right-3"><i class="bi bi-eye-fill text-muted text-base"></i></span>
                        </div>
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>

                    <button id="reset-btn" type="submit" disabled class="w-full mt-6 py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Reset Password
                    </button>


                </form>
            </div>
        </div>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const resetForm = document.getElementById('reset-form');
            const submitButton = document.getElementById('reset-btn');
            const inputs = Array.from(resetForm.querySelectorAll('input[required]'));

            const validationRules = {
                password: {
                    required: true,
                    minLength: 8,
                    message: 'Password must be at least 8 characters.'
                },
                confirm_password: {
                    required: true,
                    matches: 'password',
                    message: 'Passwords do not match.'
                },
            };

            function validateInput(input) {
                const rule = validationRules[input.name];

                // Get error element correctly for password fields
                const parentDiv = input.closest('div.mb-4, div.mb-6');
                const errorEl = parentDiv ? parentDiv.querySelector('p.text-red-500') : null;

                let isValid = true;
                let errorMessage = '';

                if (!rule) return true;

                const value = input.value;

                if (rule.required && !value.trim()) {
                    isValid = false;
                    errorMessage = rule.message.includes('required') ? rule.message : 'This field is required.';
                } else if (rule.pattern && !rule.pattern.test(value)) {
                    isValid = false;
                    errorMessage = rule.message;
                } else if (rule.minLength && value.length < rule.minLength) {
                    isValid = false;
                    errorMessage = rule.message;
                } else if (rule.matches) {
                    const matchInput = resetForm.querySelector(`[name="${rule.matches}"]`);
                    if (value !== matchInput.value) {
                        isValid = false;
                        errorMessage = rule.message;
                    }
                }

                if (errorEl) {
                    errorEl.textContent = errorMessage;
                }

                input.classList.toggle('border-red-500', !isValid);
                input.classList.toggle('focus:ring-red-300', !isValid);
                return isValid;
            }

            function checkFormValidity() {
                const isFormValid = inputs.every(validateInput);
                submitButton.disabled = !isFormValid;
            }

            resetForm.addEventListener('input', (e) => {
                if (e.target.tagName === 'INPUT' && e.target.type !== 'hidden') {
                    validateInput(e.target);
                    // When password changes, revalidate confirm password if it has a value
                    if (e.target.name === 'password') {
                        const confirmPasswordInput = resetForm.querySelector('[name="confirm_password"]');
                        if (confirmPasswordInput.value) {
                            validateInput(confirmPasswordInput);
                        }
                    }
                    checkFormValidity();
                }
            });

            resetForm.addEventListener('submit', (event) => {
                event.preventDefault();
                checkFormValidity();
                if (!submitButton.disabled) {
                    console.log('Password reset successfully!');
                    // Redirect to success page
                    window.location.href = '/success';
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
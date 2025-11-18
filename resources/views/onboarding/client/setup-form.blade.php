<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="w-full lg:w-1/2 bg-white p-6 sm:p-12">
        <a href=".." class="flex items-center space-x-2 text-muted hover:text-gray-800 transition-colors mb-8">
            <div class="rounded-full border border-muted p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <span>Back</span>
        </a>
        <div class="flex items-center justify-center h-full">
            <div class="w-full max-w-2xl px-5 sm:px-8 lg:px-0">
                <div class="text-center w-full flex-col">
                    <h1 class="text-2xl sm:text-3xl font-bold text-black font-vietnam">Find Your Perfect Talent Match</h1>
                    <p class="text-gray-500 mt-2">
                        Sign up to find talented professionals, manage projects, and grow your team.
                    </p>
                </div>

                <form id="signup-form" class="mt-8 grid sm:grid-cols-2 gap-x-4" novalidate>
                    <div class="mb-4 sm:mb-6">
                        <label for="firstname" class="block text-muted mb-1 text-sm">First name</label>
                        <input type="text" id="firstname" name="firstname" placeholder="e.g Francis" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label for="lastname" class="block text-muted mb-1 text-sm">Last name</label>
                        <input type="text" id="lastname" name="lastname" placeholder="e.g Doe" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label for="company_name" class="block text-muted mb-1 text-sm">Company Name</label>
                        <input type="text" id="company_name" name="company_name" placeholder="e.g Acme Inc." required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6 relative">
                        <label for="country-search" class="block text-muted mb-1 text-sm">Country</label>
                        <input type="text" id="country-search" placeholder="Select Country" class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 cursor-pointer" autocomplete="off">
                        <input type="hidden" name="country" id="country-hidden" required>
                        <div id="country-dropdown" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar hidden">
                            <!-- Countries will be populated here -->
                        </div>
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label for="email" class="block text-muted mb-1 text-sm">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="e.g francis@mail.com" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label for="company_website" class="block text-muted mb-1 text-sm">Company Website</label>
                        <input type="url" id="company_website" name="company_website" placeholder="https://example.com" required class="w-full px-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <p class="text-red-500 text-xs mt-1 h-4"></p>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label for="password" class="block text-muted mb-1 text-sm">Password</label>
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
                    <button id="submit-btn" type="submit" disabled class="mt-4 w-full py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl font-semibold shadow hover:opacity-90 transition col-span-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        Create Account
                    </button>
                </form>

                <p class="text-center text-muted mt-6">
                    Already have an account? <a href="/" class="font-semibold text-primary hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const signupForm = document.getElementById('signup-form');
            const submitButton = document.getElementById('submit-btn');
            const inputs = Array.from(signupForm.querySelectorAll('input[required]'));

            const validationRules = {
                firstname: {
                    required: true,
                    message: 'First name is required.'
                },
                lastname: {
                    required: true,
                    message: 'Last name is required.'
                },
                company_name: {
                    required: true,
                    message: 'Company name is required.'
                },
                country: {
                    required: true,
                    message: 'Country is required.'
                },
                email: {
                    required: true,
                    pattern: /^\S+@\S+\.\S+$/,
                    message: 'Please enter a valid email.'
                },
                company_website: {
                    required: true,
                    pattern: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,
                    message: 'Please enter a valid URL.'
                },
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
                // For country, the error message should be on the parent div of the search input
                const errorEl = input.name === 'country' ?
                    document.getElementById('country-search').parentElement.querySelector('p') :
                    input.parentElement.nextElementSibling;

                let isValid = true;
                let errorMessage = '';

                if (!rule) return true;

                const value = input.name === 'country' ? document.getElementById('country-hidden').value : input.value;

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
                    const matchInput = signupForm.querySelector(`[name="${rule.matches}"]`);
                    if (value !== matchInput.value) {
                        isValid = false;
                        errorMessage = rule.message;
                    }
                }

                if (errorEl) {
                    errorEl.textContent = errorMessage;
                }

                const inputToStyle = input.name === 'country' ? document.getElementById('country-search') : input;
                inputToStyle.classList.toggle('border-red-500', !isValid);
                inputToStyle.classList.toggle('focus:ring-red-300', !isValid);
                return isValid;
            }

            function checkFormValidity() {
                // Use hidden country input for validation check
                const allInputs = [...inputs, document.getElementById('country-hidden')];
                const isFormValid = allInputs.every(validateInput);
                submitButton.disabled = !isFormValid;
            }

            signupForm.addEventListener('input', (e) => {
                if (e.target.tagName === 'INPUT' && e.target.type !== 'hidden') {
                    validateInput(e.target);
                    if (e.target.name === 'password') {
                        validateInput(signupForm.querySelector('[name="confirm_password"]'));
                    }
                    checkFormValidity();
                }
            });

            signupForm.addEventListener('submit', (event) => {
                event.preventDefault();
                checkFormValidity(); // Final check on submit
                if (!submitButton.disabled) {
                    console.log('Form submitted successfully!');
                    // Redirect to the verification page
                    window.location.href = '/verify-email';
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

            // --- COUNTRY DROPDOWN LOGIC ---
            const countrySearch = document.getElementById('country-search');
            const countryDropdown = document.getElementById('country-dropdown');
            const countryHiddenInput = document.getElementById('country-hidden');
            let countries = [];

            async function fetchCountries() {
                try {
                    countryDropdown.innerHTML = `<div class="p-4 text-sm text-gray-500">Loading...</div>`;
                    const response = await fetch('https://restcountries.com/v3.1/all?fields=name');
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    countries = data.map(c => c.name.common).sort();
                    renderCountries(countries);
                } catch (error) {
                    console.error('Failed to fetch countries:', error);
                    countryDropdown.innerHTML = `<div class="p-4 text-sm text-red-500">Could not load countries.</div>`;
                }
            }

            function renderCountries(list) {
                countryDropdown.innerHTML = '';
                if (list.length === 0) {
                    countryDropdown.innerHTML = `<div class="p-4 text-sm text-gray-500">No matches found.</div>`;
                    return;
                }
                list.forEach(country => {
                    const li = document.createElement('li');
                    li.textContent = country;
                    li.className = 'px-4 py-2 cursor-pointer hover:bg-gray-100';
                    li.addEventListener('click', () => {
                        countrySearch.value = country;
                        countryHiddenInput.value = country;
                        countryDropdown.classList.add('hidden');
                        validateInput(countryHiddenInput); // Validate on selection
                        checkFormValidity();
                    });
                    countryDropdown.appendChild(li);
                });
            }

            countrySearch.addEventListener('focus', () => {
                if (!countries.length) fetchCountries();
                countryDropdown.classList.remove('hidden');
            });

            countrySearch.addEventListener('input', () => {
                const searchTerm = countrySearch.value.toLowerCase();
                const filtered = countries.filter(c => c.toLowerCase().includes(searchTerm));
                renderCountries(filtered);
            });

            document.addEventListener('click', (e) => {
                if (!countrySearch.parentElement.contains(e.target)) {
                    countryDropdown.classList.add('hidden');
                }
            });

            fetchCountries();
        });
    </script>
    @endpush

</x-layouts.app>
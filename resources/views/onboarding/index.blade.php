<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="w-full  lg:w-1/2 bg-white p-6 sm:p-12">
        <a href=".." class="flex items-center space-x-2 text-muted hover:text-gray-800 transition-colors mb-8">
            <div class="rounded-full border border-muted">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
            </div>
            <span>Back</span>
        </a>

        <div class="w-full max-w-2xl">

            <div class="flex flex-col items-center justify-center py-10">

                <h2 class="text-4xl font-semibold mb-2">Join As A Client Or Candidate</h2>
                <p class="text-muted mb-8">Help us tailor your setup by choosing your account type.</p>


                <form id="signup-form" class="mt-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <!-- Client Card -->
                        <div id="client-card" class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 flex flex-col items-start text-left h-full border-gray-200 bg-white hover:border-gray-300 hover:shadow-md" role="button" aria-pressed="false">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-md mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 13v6a2 2 0 002 2h10a2 2 0 002-2v-6" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-black mb-1">Client</h3>
                            <p class="text-sm text-muted">I'm a client, hiring for a project</p>
                        </div>
                        <!-- Employment Card -->
                        <div id="employment-card" class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 flex flex-col items-start text-left h-full border-gray-200 bg-white hover:border-gray-300 hover:shadow-md" role="button" aria-pressed="false">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-md mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-black mb-1">Full-Time Employment</h3>
                            <p class="text-sm text-muted">I'm looking for a steady 9-to-5 job.</p>
                        </div>
                    </div>

                    <button id="submit-btn" type="submit" disabled class="w-full bg-gradient-to-r from-[#68A3FF] to-primary text-white font-semibold py-3 px-4 mt-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        Create Account
                    </button>
                </form>

                <p class="text-center text-muted mt-6">
                    Already have an account? <a href="#" class="font-semibold text-primary hover:underline">Login</a>
                </p>

            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clientCard = document.getElementById('client-card');
            const employmentCard = document.getElementById('employment-card');
            const signupForm = document.getElementById('signup-form');
            const submitButton = document.getElementById('submit-btn');

            let selectedAccount = null;

            const selectedClasses = ['border-indigo-500', 'bg-indigo-50', 'shadow-lg', 'scale-105'];
            const unselectedClasses = ['border-gray-200', 'bg-white', 'hover:border-gray-300', 'hover:shadow-md'];

            const updateSelection = (selection) => {
                selectedAccount = selection;

                if (selection === 'client') {
                    clientCard.classList.remove(...unselectedClasses);
                    clientCard.classList.add(...selectedClasses);
                    clientCard.setAttribute('aria-pressed', 'true');

                    employmentCard.classList.remove(...selectedClasses);
                    employmentCard.classList.add(...unselectedClasses);
                    employmentCard.setAttribute('aria-pressed', 'false');
                } else if (selection === 'employment') {
                    employmentCard.classList.remove(...unselectedClasses);
                    employmentCard.classList.add(...selectedClasses);
                    employmentCard.setAttribute('aria-pressed', 'true');

                    clientCard.classList.remove(...selectedClasses);
                    clientCard.classList.add(...unselectedClasses);
                    clientCard.setAttribute('aria-pressed', 'false');
                }

                submitButton.disabled = !selectedAccount;
            };

            clientCard.addEventListener('click', () => {
                updateSelection('client');
            });

            employmentCard.addEventListener('click', () => {
                updateSelection('employment');
            });

            signupForm.addEventListener('submit', (event) => {
                event.preventDefault();
                if (selectedAccount == 'client') {
                    window.location.href = '/client/setup'
                    // alert(`Creating account as: ${selectedAccount}`);
                    // In a real application, you would make an API call here.
                }
            });
        });
    </script>
    @endpush

</x-layouts.app>
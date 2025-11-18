<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="w-full lg:w-1/2 bg-white p-6 sm:p-12">
        <!-- Back Button -->
        <a href=".." class="inline-flex items-center space-x-2 text-muted hover:text-black transition-colors">
            <div class="rounded-full border-2 border-gray-300 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <span class="text-lg">Back</span>
        </a>
        <div class="max-w-2xl mx-auto px-6 py-8">

            <!-- Main Content -->
            <div class="flex flex-col items-center justify-center text-center mt-12">
                <!-- Title -->
                <h1 class="text-3xl font-bold text-black mb-6">
                    A Code Has Been Sent To Your Mail
                </h1>

                <!-- Email Display -->
                <div class="flex items-center space-x-2 text-gray-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span id="masked-email" class="text-sm text-primary">ag**********************</span>
                </div>

                <!-- Subtitle -->
                <p class="text-muted mb-12">
                    Kindly enter the 6-digit code sent to your email.
                </p>

                <!-- OTP Input Boxes -->
                <div class="flex items-center justify-center space-x-3 mb-8">
                    <input type="text" maxlength="1" class="otp-input w-16 h-16 md:w-20 md:h-20 text-center text-2xl md:text-3xl font-bold border-2 border-muted rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="0">
                    <input type="text" maxlength="1" class="otp-input w-16 h-16 md:w-20 md:h-20 text-center text-2xl md:text-3xl font-bold border-2 border-muted rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="1">
                    <input type="text" maxlength="1" class="otp-input w-16 h-16 md:w-20 md:h-20 text-center text-2xl md:text-3xl font-bold border-2 border-muted rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="2">
                    <input type="text" maxlength="1" class="otp-input w-16 h-16 md:w-20 md:h-20 text-center text-2xl md:text-3xl font-bold border-2 border-muted rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="3">
                    <input type="text" maxlength="1" class="otp-input w-16 h-16 md:w-20 md:h-20 text-center text-2xl md:text-3xl font-bold border-2 border-muted rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="4">
                    <input type="text" maxlength="1" class="otp-input w-16 h-16 md:w-20 md:h-20 text-center text-2xl md:text-3xl font-bold border-2 border-muted rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="5">
                </div>

                <!-- Resend Code -->
                <div class="mb-12">
                    <button id="resend-btn" class="text-black font-medium hover:text-blue-600 transition-colors disabled:text-gray-400 disabled:cursor-not-allowed">
                        Send code again
                    </button>
                    <span id="timer" class="text-muted ml-2">00:20</span>
                </div>

                <!-- Continue Button -->
                <button id="continue-btn" disabled class="w-full max-w-md py-4 bg-primary text-white text-lg font-semibold rounded-2xl shadow-lg hover:bg-blue-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-primary">
                    Continue
                </button>
            </div>
        </div>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const otpInputs = document.querySelectorAll('.otp-input');
            const continueBtn = document.getElementById('continue-btn');
            const resendBtn = document.getElementById('resend-btn');
            const timerDisplay = document.getElementById('timer');

            let timeLeft = 20;
            let timerInterval;

            // Start countdown timer
            function startTimer() {
                resendBtn.disabled = true;
                timeLeft = 20;

                timerInterval = setInterval(() => {
                    timeLeft--;
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        resendBtn.disabled = false;
                        timerDisplay.textContent = '';
                    }
                }, 1000);
            }

            // Initialize timer
            startTimer();

            // Handle resend button
            resendBtn.addEventListener('click', () => {
                console.log('Resending code...');
                startTimer();
                // Clear all inputs
                otpInputs.forEach(input => input.value = '');
                otpInputs[0].focus();
            });

            // Check if all inputs are filled
            function checkComplete() {
                const allFilled = Array.from(otpInputs).every(input => input.value.length === 1);
                continueBtn.disabled = !allFilled;
            }

            // Handle OTP input
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;

                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }

                    if (value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }

                    checkComplete();
                });

                input.addEventListener('keydown', (e) => {
                    // Handle backspace
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }

                    // Handle arrow keys
                    if (e.key === 'ArrowLeft' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                // Handle paste
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').slice(0, 6);

                    if (!/^\d+$/.test(pasteData)) return;

                    pasteData.split('').forEach((char, i) => {
                        if (index + i < otpInputs.length) {
                            otpInputs[index + i].value = char;
                        }
                    });

                    const lastFilledIndex = Math.min(index + pasteData.length - 1, otpInputs.length - 1);
                    otpInputs[lastFilledIndex].focus();
                    checkComplete();
                });
            });

            // Handle continue button
            continueBtn.addEventListener('click', () => {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                console.log('OTP entered:', otp);
                // alert(`Verifying OTP: ${otp}`);
                // Add your verification logic here
                window.location.href = '/success'
            });

            // Focus first input on load
            otpInputs[0].focus();
        });
    </script>
    @endpush
</x-layouts.app>
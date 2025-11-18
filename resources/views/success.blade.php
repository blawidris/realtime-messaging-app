<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>
    <div class="w-full lg:w-1/2 bg-white p-6 sm:p-12 flex flex-col items-center justify-center">
        <div class="max-w-xl text-center">

            <div class="relative w-32 h-32 mx-auto mb-8 animate-scale-in">
                <!-- Decorative Elements -->
                <!-- <span class="absolute top-1 right-2 h-1 w-1 bg-green-200 rounded-full" style="animation: scale-in 0.5s 0.6s backwards;"></span>
                <span class="absolute top-1/4 right-0 -translate-y-1/2 translate-x-3 h-2.5 w-1.5 bg-green-200 rounded-full -rotate-45" style="animation: scale-in 0.5s 0.7s backwards;"></span>
                <span class="absolute bottom-1/4 right-0.5 translate-y-1/2 translate-x-3 w-3 h-1 bg-green-200 rounded-full" style="animation: scale-in 0.5s 0.8s backwards;"></span>
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-3 h-1.5 w-3 bg-green-200 rounded-full" style="animation: scale-in 0.5s 0.9s backwards;"></span>
                <span class="absolute bottom-1 left-2 h-2 w-2 bg-green-200 rounded-full" style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%); animation: scale-in 0.5s 1s backwards;"></span>
                <span class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-2.5 w-4 h-1 bg-green-200 rounded-full" style="animation: scale-in 0.5s 1.1s backwards;"></span> -->

                <!-- Main Circle -->
                <!-- <div class="w-full h-full rounded-full bg-green-100 flex items-center justify-center p-2"> -->
                    <img src="{{asset('images/succes-check.gif')}}" alt="" class="w-full h-full object-cover">
                    <!-- <div class="w-full h-full rounded-full bg-green-500 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path class="animate-tick-in" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" style="stroke-dasharray: 24; stroke-dashoffset: 24;"></path>
                        </svg> -->
                <!-- </div> -->
            </div>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-black font-vietnam">Password Reset Successfully!</h1>
        <p class="text-muted mt-3 text-center text-base">
            Your password has been updated. You can now sign in <br/> with your new credentials.
        </p>

        <a href="/" class="mt-8 w-full max-w-md block py-3 bg-gradient-to-r from-[#68A3FF] to-primary text-white rounded-xl text-center font-semibold shadow hover:opacity-90 transition">
            Go to login
        </a>
    </div>
    </div>
</x-layouts.app>
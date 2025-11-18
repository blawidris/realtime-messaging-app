@props(['title' => 'Top Talents at your Finger tip'])

<aside class="hidden lg:flex w-1/2 starry-background text-white p-12 flex-col justify-between relative overflow-hidden">

    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-[#40576D] to-[#0E253B] -z-10"></div>

    <div class="absolute inset-0 z-0">
        <!-- Talent Card: Dare -->
        <div class="profile-card absolute top-32 left-10 transform -translate-x-1/2 -translate-y-1/2 transition-transform duration-500 hover:scale-110">
            <div class="relative w-40 h-48 bg-gradient-to-br from-red-400 to-pink-500 rounded-xl overflow-hidden shadow-2xl">
                <img src="{{ asset('images/dare.png') }}" alt="Dare" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-red-400 opacity-20"></div>
                <div class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-40 backdrop-blur-sm">
                    <div class="flex items-center space-x-1">
                        <p class="text-white text-sm font-semibold">Dare</p>
                        <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zM16.707 9.293a1 1 0 00-1.414-1.414L11 12.172l-1.793-1.793a1 1 0 00-1.414 1.414l2.5 2.5a1 1 0 001.414 0l5-5z" fill="currentColor" />
                        </svg>
                    </div>
                    <p class="text-white text-xs opacity-80">Product Designer</p>
                </div>
            </div>
        </div>
        <!-- Talent Card: Freda -->
        <div class="profile-card absolute top-[3.5rem] right-0 transform translate-x-1/4 -translate-y-1/4 transition-transform duration-500 hover:scale-110">
            <div class="relative w-40 h-48 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl overflow-hidden shadow-2xl">
                <img src="{{ asset('images/dzifa.png') }}" alt="Freda" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-cyan-400 opacity-20"></div>
                <div class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-40 backdrop-blur-sm">
                    <div class="flex items-center space-x-1">
                        <p class="text-white text-sm font-semibold">Freda</p>
                        <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zM16.707 9.293a1 1 0 00-1.414-1.414L11 12.172l-1.793-1.793a1 1 0 00-1.414 1.414l2.5 2.5a1 1 0 001.414 0l5-5z" fill="currentColor" />
                        </svg>
                    </div>
                    <p class="text-white text-xs opacity-80">Business Analyst</p>
                </div>
            </div>
        </div>
        <!-- Talent Card: Nuella -->
        <div class="profile-card absolute bottom-60 left-1/2 transform -translate-x-1/4 -translate-y-1/2 transition-transform duration-500 hover:scale-110">
            <div class="relative w-44 h-44 bg-gradient-to-br from-purple-400 to-indigo-600  w-32 h-40 rounded-xl overflow-hidden shadow-2xl">
                <img src="{{ asset('images/neula.png') }}" alt="Nuella" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-purple-400 opacity-20"></div>
                <div class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-40 backdrop-blur-sm">
                    <div class="flex items-center space-x-1">
                        <p class="text-white text-sm font-semibold">Nuella</p>
                        <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zM16.707 9.293a1 1 0 00-1.414-1.414L11 12.172l-1.793-1.793a1 1 0 00-1.414 1.414l2.5 2.5a1 1 0 001.414 0l5-5z" fill="currentColor" />
                        </svg>
                    </div>
                    <p class="text-white text-xs opacity-80">Customer Support</p>
                </div>
            </div>
        </div>
    </div>


    <div class="relative z-10">
        <a href="/" class="">
            <img src="{{ asset('images/logo-white.png') }}" alt="">
        </a>
    </div>
    <!-- Features -->
    <div class="relative z-10">
        <h2 class="text-4xl font-medium leading-tight mb-8">
            Top Talents at<br />your Finger tip
        </h2>
        <div class="flex space-x-4">
            <!-- Feature Tab 1 -->
            <div class="rounded-xl p-4 w-40 h-32 flex flex-col justify-between transition-all duration-300 bg-white text-brand-dark">
                <div class="text-white bg-black rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">1</div>
                <div class="text-black">
                    <h3 class="font-semibold">Top Tier</h3>
                    <p class="font-semibold">Talents</p>
                </div>
            </div>

            <!-- Feature Tab 2 -->
            <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 w-40 h-32 flex flex-col justify-between transition-all duration-300 bg-brand-dark-accent text-white">
                <div class="bg-black bg-opacity-20 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">2</div>
                <div>
                    <h3 class="font-semibold">Effortless</h3>
                    <p class="font-semibold">Management</p>
                </div>
            </div>
            <!-- Feature Tab 3 -->
            <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 w-40 h-32 flex flex-col justify-between transition-all duration-300 bg-brand-dark-accent text-white">
                <div class="bg-black bg-opacity-20 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">3</div>
                <div>
                    <h3 class="font-semibold">Seamless</h3>
                    <p class="font-semibold">Opportunities</p>
                </div>
            </div>
        </div>
    </div>

</aside>




@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #1e3a5f 0%, #0f1c2e 100%);
        background-image:
            radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            radial-gradient(circle at 60% 70%, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 100px 100px, 150px 150px, 200px 200px;
    }

    .profile-card {
        animation: float 6s ease-in-out infinite;
    }

    .profile-card:nth-child(2) {
        animation-delay: 2s;
    }

    .profile-card:nth-child(3) {
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }
</style>
@endpush
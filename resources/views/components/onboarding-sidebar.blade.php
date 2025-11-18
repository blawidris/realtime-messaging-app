@props(['title' => 'Top Talents at your Finger tip'])

<div class="relative text-white space-y-10 hidden md:block overflow-hidden h-full
    bg-[url('{{ asset('images/noisebg.png') }}')] bg-no-repeat bg-cover">
    
    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-[#40576D] to-[#0E253B] -z-10"></div>


    <div class="px-10 lg:px-20">
        <a href="/" class="">
            <img src="{{ asset('images/logo-white.png') }}" alt="">
        </a>
    </div>

    <!-- Profile Cards -->
    <div class="relative h-96 hidden lg:block -top-4">
        <!-- Dare -->
        <div class="profile-card absolute top-10 left-10 w-40 h-48 bg-gradient-to-br from-red-400 to-pink-500 rounded-2xl p-4 flex flex-col justify-end shadow-2xl">
            <div class="bg-white/20 backdrop-blur-sm rounded-full w-20 h-20 mb-3"></div>
            <div class="text-white">
                <p class="font-semibold">Dare ✓</p>
                <p class="text-xs opacity-90">Product Designer</p>
            </div>
        </div>

        <!-- Freda -->
        <div class="profile-card absolute -top-12 -right-6 w-40 h-48 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl p-4 flex flex-col justify-end shadow-2xl">
            <div class="bg-white/20 backdrop-blur-sm rounded-full w-16 h-16 mb-2"></div>
            <div class="text-white">
                <p class="font-semibold text-sm">Freda ✓</p>
                <p class="text-xs opacity-90">Business Analyst</p>
            </div>
        </div>

        <!-- Stells -->
        <div class="profile-card absolute bottom-4 right-0 lg:right-60 w-44 h-44 bg-gradient-to-br from-purple-400 to-indigo-600 rounded-2xl p-4 flex flex-col justify-end shadow-2xl">
            <div class="bg-white/20 backdrop-blur-sm rounded-full w-20 h-20 mb-3"></div>
            <div class="text-white">
                <p class="font-semibold">Nuella ✓</p>
                <p class="text-xs opacity-90">Customer Support</p>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="mb-20 px-8 -mt-10">
        <h2 class="text-4xl font-medium mb-8 xl:w-70">{{ $title }}</h2>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 font-vietnam">
            <div class="bg-white rounded-xl p-6 text-gray-800">
                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold mb-3">1</div>
                <p class="font-semibold">Top Tier<br>Talents</p>
            </div>
            <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl p-6 text-white">
                <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center font-bold mb-3">2</div>
                <p class="font-semibold">Effortless<br>Management</p>
            </div>
            <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl p-6 text-white">
                <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center font-bold mb-3">3</div>
                <p class="font-semibold">Seamless<br>Opportunities</p>
            </div>
        </div>
    </div>
</div>

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
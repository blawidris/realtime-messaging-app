@props([
'title' => $title ?? '',
])

<header class="flex items-center justify-between w-full px-6 py-8">

    <!-- LEFT: Breadcrumb -->
    <div class="flex items-center gap-1 text-base md:text-lg">
        <a href="" class="text-primary font-medium hover:underline">Dashboard</a>
        @if ($title)
        <span class="text-muted">/</span>
        <span class="text-black font-medium">{{ $title }}</span>
        @endif
    </div>


    <!-- RIGHT: Search + Notifications + Profile -->
    <div class="flex items-center gap-6">
        <!-- Search -->
    
        <div class="hidden lg:block relative w-80 bg-white h-12 rounded-lg">
            <input type="text"
                class="w-full h-full py-4 px-6 indent-7 border-0 bg-white text-muted placeholder:text-muted focus:outline-none focus:ring-1 focus:ring-primary"
                placeholder="Search" />
            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-muted"></i>
        </div>

        <!-- Notifications -->
        <div class="relative cursor-pointer bg-white p-2 px-4 rounded-lg">
            <i class="far fa-bell text-xl text-gray-600"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs size-3 rounded-full"></span>
        </div>

        <!-- Profile Dropdown -->

        <x-ui.dropdown
            width="56"
            class="w-full sm:w-auto">
            <x-slot name="trigger">
                <button class="flex items-center gap-2 focus:outline-none">
                    <img src="{{ Auth::user()->avatar_url ?? 'https://i.pravatar.cc/50?u=' . Auth::id() }}"
                        class="size-10 rounded-full object-cover border border-muted" />

                    <span class="text-gray-800 font-medium hidden lg:block">{{ Auth::user()?->name ?? "Victor E" }}</span>
                    <i class="fas fa-chevron-down text-muted text-sm"></i>
                </button>
            </x-slot>

            <x-slot name="content">
                <a href=""
                    class="block px-4 py-3 text-sm text-black hover:bg-[#F8FCFF] hover:text-primary">
                    My Profile
                </a>

                <form method="POST" action="">
                    @csrf
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-black hover:bg-[#F8FCFF] hover:text-primary">
                        Logout
                    </button>
                </form>
            </x-slot>
        </x-ui.dropdown>

        {{-- <div class="relative">
            <button id="profileBtn" class="flex items-center gap-2 focus:outline-none">
                <img src="{{ Auth::user()->avatar_url ?? 'https://i.pravatar.cc/50?u=' . Auth::id() }}"
        class="size-10 rounded-full object-cover border border-muted" />

        <span class="text-gray-800 font-medium">{{ Auth::user()?->name ?? "Victor E" }}</span>
        <i class="fas fa-chevron-down text-muted text-sm"></i>
        </button>

        <div id="profileMenu"
            class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg border border-gray-100 hidden">

            <a href=""
                class="block px-4 py-3 text-sm text-black hover:bg-[#F8FCFF] hover:text-primary">
                My Profile
            </a>

            <form method="POST" action="">
                @csrf
                <button
                    class="w-full text-left px-4 py-2 text-sm text-black hover:bg-[#F8FCFF] hover:text-primary">
                    Logout
                </button>
            </form>

        </div>
    </div> --}}

    </div>
</header>

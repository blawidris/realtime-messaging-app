@props([
'show' => false,
'maxWidth' => '2xl',
])

<div
    x-show="{{ $show }}"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div
        class="absolute inset-0 bg-black/40"
        @click="{{ $show }} = false"></div>

    <!-- Modal -->
    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-{{$maxWidth}}">
        {{-- Header --}}
        @isset($header)
        <div class="flex items-center justify-between px-6 py-4 w-full">
            <h3 class="text-lg font-semibold">{{ $header }}</h3>

            <button @click="{{ $show }} = false" class="size-10 rounded-full bg-gray-[#CCCCCC1A] hover:bg-gray-[#CCCCCC] flex items-center justify-center cursor-pointer">
                <i class="bi bi-x-lg  text-black"></i>
            </button>
        </div>
        @endisset

        {{-- Body --}}
        <div class="px-6 py-4">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @isset($footer)
        <div class="px-6 py-4 flex justify-end gap-3">
            {{ $footer }}
        </div>
        @endisset
    </div>
</div>
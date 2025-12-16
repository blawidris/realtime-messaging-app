@props(['step' => 1])

<div class="bg-[#0B1F33] text-white">
    <div class="max-w-7xl mx-auto px-6 py-6 flex justify-center gap-12">

        @foreach([1 => 'Top up', 2 => 'Payment', 3 => 'Complete'] as $num => $label)
        <div class="flex items-center gap-3">
            <span
                class="size-8 rounded-full border flex items-center justify-center text-sm"
                :class="step >= {{ $num }}
                        ? 'bg-white text-[#0B1F33]'
                        : 'border-white/40 text-white/60'">
                {{ $num }}
            </span>

            <span
                class="text-sm"
                :class="step >= {{ $num }} ? 'text-white' : 'text-white/60'">
                {{ $label }}
            </span>
        </div>
        @endforeach

    </div>
</div>
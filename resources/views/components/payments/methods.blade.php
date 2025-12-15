<div class="space-y-6 bg-white py-10 px-6">
    {{-- Search --}}
    <div class="flex justify-end">
        <div class="relative w-72">
            <input
                type="text"
                placeholder="Search"
                class="indent-6 py-2 border border-[#EBEDF0] bg-[#FAFAFA] rounded-lg text-sm focus:ring-0 focus:border-gray-300 w-full" />
            <svg class="absolute left-3 top-3 size-5 text-muted"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m21 21-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" />
            </svg>
        </div>
    </div>

    {{-- Cards --}}
    <div class="space-y-4">
        @foreach($cards as $card)
        @php
        $isDefault = $card['is_default'] ?? false;
        @endphp

        <div class="grid sm:grid-cols-2 border gap-8">

            <div class="flex items-center gap-4 justify-between w-full">
                {{-- Radio --}}

                <div class="inline-flex gap-4">
                    <span
                        class="mt-1 flex h-5 w-5 items-center justify-center rounded-full
                                {{ $isDefault ? 'border-primary' : 'border-primary/70' }} border">
                        @if($isDefault)
                        <span class="h-2.5 w-2.5 rounded-full bg-primary"></span>
                        @endif
                    </span>
                    @if($isDefault)
                    <p class="text-sm font-medium text-primary">Default</p>
                    @endif
                </div>

                {{-- Card info --}}
                <div class="inline-flex flex-col gap-1.5">
                    <h4 class="text-base font-semibold text-black">
                        {{ $card['name'] }}
                    </h4>

                    <p class="text-sm text-gray-500">
                        Expires: {{ $card['expiry'] }}
                    </p>
                </div>
            </div>

            {{-- Right --}}
            <div class="flex items-center w-full justify-between">
                <div class="text-right px-5">
                    <p class="text-sm font-medium text-black">
                        **** **** **** {{ $card['last4'] }}
                    </p>

                    {{-- Brand --}}
                    @if($card['brand'] === 'visa')
                    <span class="text-primary font-semibold italic">VISA</span>
                    @elseif($card['brand'] === 'mastercard')
                    <div class="flex justify-end gap-1">
                        <span class="h-4 w-4 rounded-full bg-[#D80027]"></span>
                        <span class="h-4 w-4 rounded-full bg-yellow-400 -ml-1"></span>
                    </div>
                    @endif
                </div>

                {{-- Delete --}}
                <button
                    type="button"
                    class="flex items-center justify-center rounded-full bg-[#FEE4E2] text-[#D80027] size-10"
                    aria-label="Delete card">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Add new card --}}
    <button
        type="button"
        class="w-full py-4 rounded-xl border border-dashed border-blue-300 bg-blue-50 text-blue-700 font-medium hover:bg-blue-100 transition">
        Add new card
    </button>
</div>
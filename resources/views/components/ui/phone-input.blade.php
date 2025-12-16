@props([
'name' => 'phone',
'codeName' => 'country_code',
'required' => false,
'value' => old('phone'),
'code' => old('country_code', '+233'),
])

@php
$countries = config('countries');
$selected = collect($countries)->firstWhere('code', $code) ?? $countries[0];
@endphp

<div
    x-data="{
        open: false,
        search: '',
        countries: @js($countries),
        selected: @js($selected),
        get filtered() {
            return this.countries.filter(c =>
                c.name.toLowerCase().includes(this.search.toLowerCase()) ||
                c.code.includes(this.search)
            )
        }
    }"
    class="flex gap-2 w-full">
    <!-- hidden country code -->
    <input type="hidden" name="{{ $codeName }}" :value="selected.code">

    <!-- country selector -->
    <div class="relative">
        <button
            type="button"
            @click="open = !open"
            class="flex items-center gap-2 px-3 py-3 border rounded-lg bg-white min-w-[96px]">
            <img :src="`https://flagcdn.com/w20/${selected.iso}.png`" class="w-5 h-4 rounded-sm">
            <span x-text="selected.code" class="font-medium"></span>
            <i class="bi bi-chevron-down text-xs"></i>
        </button>

        <div
            x-show="open"
            @click.outside="open=false"
            x-transition
            class="absolute z-50 mt-2 w-64 bg-white border rounded-xl shadow-lg">
            <input
                x-model="search"
                placeholder="Search country"
                class="w-full px-3 py-2 border-b outline-none">

            <ul class="max-h-60 overflow-y-auto">
                <template x-for="c in filtered" :key="c.iso">
                    <li>
                        <button
                            type="button"
                            @click="selected=c; open=false; search=''"
                            class="w-full px-4 py-2 flex items-center gap-3 hover:bg-gray-100">
                            <img :src="`https://flagcdn.com/w20/${c.iso}.png`" class="w-5 h-4">
                            <span class="font-medium" x-text="c.code"></span>
                            <span class="text-sm text-gray-500" x-text="c.name"></span>
                        </button>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <!-- phone number input -->
    <input
        type="tel"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
        placeholder="Phone number"
        class="flex-1 px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
</div>
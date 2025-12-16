@props([
'name' => 'location',
'required' => false,
'value' => old('location'),
])

@php
$countries = config('countries');
$selected = collect($countries)->firstWhere('name', $value) ?? null;
@endphp

<div
    x-data="{
        open: false,
        search: '',
        countries: @js($countries),
        selected: @js($selected),
        get filtered() {
            return this.countries.filter(c =>
                c.name.toLowerCase().includes(this.search.toLowerCase())
            )
        }
    }"
    class="relative w-full">
    <input type="hidden" name="{{ $name }}" :value="selected?.name ?? ''">

    <button
        type="button"
        @click="open=!open"
        class="w-full px-4 py-3 border rounded-lg bg-white flex items-center justify-between"
        :class="!selected ? 'text-gray-400' : ''">
        <div class="flex items-center gap-3">
            <template x-if="selected">
                <img :src="`https://flagcdn.com/w20/${selected.iso}.png`" class="w-5 h-4 rounded-sm">
            </template>
            <span x-text="selected?.name ?? 'Select country'"></span>
        </div>
        <i class="bi bi-chevron-down"></i>
    </button>

    <div
        x-show="open"
        @click.outside="open=false"
        x-transition
        class="absolute z-50 mt-2 w-full bg-white border rounded-xl shadow-lg">
        <input
            x-model="search"
            placeholder="Search country"
            class="w-full px-3 py-2 border-b outline-none">

        <ul class="max-h-64 overflow-y-auto">
            <template x-for="c in filtered" :key="c.iso">
                <li>
                    <button
                        type="button"
                        @click="selected=c; open=false; search=''"
                        class="w-full px-4 py-2 flex items-center gap-3 hover:bg-gray-100">
                        <img :src="`https://flagcdn.com/w20/${c.iso}.png`" class="w-5 h-4">
                        <span x-text="c.name"></span>
                    </button>
                </li>
            </template>
        </ul>
    </div>

    @if($required)
    <input type="text" class="hidden" required :value="selected?.name">
    @endif
</div>
@props([
'name' => 'country_code',
'value' => old('country_code', '+234'),
])

@php
$countries = [
['name' => 'Nigeria', 'code' => '+234', 'iso' => 'ng'],
['name' => 'Ghana', 'code' => '+233', 'iso' => 'gh'],
['name' => 'Kenya', 'code' => '+254', 'iso' => 'ke'],
['name' => 'South Africa', 'code' => '+27', 'iso' => 'za'],
['name' => 'United States', 'code' => '+1', 'iso' => 'us'],
['name' => 'United Kingdom', 'code' => '+44', 'iso' => 'gb'],
];

$selected = collect($countries)->firstWhere('code', $value) ?? $countries[0];
@endphp

<div
    x-data="{
        open: false,
        search: '',
        selected: @js($selected),
        countries: @js($countries),
        get filtered() {
            return this.countries.filter(c =>
                c.name.toLowerCase().includes(this.search.toLowerCase()) ||
                c.code.includes(this.search)
            )
        }
    }"
    class="relative w-auto">
    <!-- Hidden input for form submission -->
    <input type="hidden" name="{{ $name }}" :value="selected.code">

    <!-- Trigger -->
    <button
        type="button"
        @click="open = !open"
        class="w-full px-4 py-3 border border-muted rounded-lg bg-white flex items-center justify-between focus:ring-2 focus:ring-blue-500">
        <div class="flex items-center gap-3">
            <img
                :src="`https://flagcdn.com/w20/${selected.iso}.png`"
                :alt="selected.name"
                class="w-5 h-4 rounded-sm">
            <span class="font-medium" x-text="selected.code"></span>
        </div>

        <i class="bi bi-chevron-down text-muted"></i>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute z-50 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg">
        <!-- Search -->
        <div class="p-3 border-b">
            <input
                type="text"
                x-model="search"
                placeholder="Search country"
                class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:text-primaryoutline-none  text-xs">
        </div>

        <!-- Options -->
        <ul class="max-h-64 overflow-y-auto">
            <template x-for="country in filtered" :key="country.code">
                <li>
                    <button
                        type="button"
                        @click="selected = country; open = false; search = ''"
                        class="w-full px-4 py-3 flex items-center gap-3 hover:bg-blue-50 transition">
                        <img
                            :src="`https://flagcdn.com/w20/${country.iso}.png`"
                            :alt="country.name"
                            class="w-5 h-4 rounded-sm">
                        <span class="font-medium" x-text="country.code"></span>
                    </button>
                </li>
            </template>

            <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-muted">
                No results found
            </li>
        </ul>
    </div>
</div>
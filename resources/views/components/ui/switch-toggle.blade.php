@props([
    'model' => null,          // alpine model (optional)
    'checked' => false,       // default state
    'disabled' => false,
    'size' => 'md',           // sm | md | lg
    'label' => null,
    'name' => null,           // for forms
    'class' => '',
])

@php
$sizes = [
    'sm' => 'w-9 h-6',
    'md' => 'w-11 h-6',
    'lg' => 'w-14 h-8',
];

$dotSizes = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-7 h-7',
];
@endphp

<div
    x-data="{
        on: {{ $checked ? 'true' : 'false' }},
    }"
    {{ $attributes->whereDoesntStartWith('class') }}
    class="flex items-center gap-3 {{ $class }}"
>
    <!-- Hidden input for forms -->
    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="on ? 1 : 0">
    @endif

    <button
        type="button"
        role="switch"
        :aria-checked="on.toString()"
        @click="if (!{{ $disabled ? 'true' : 'false' }}) on = !on"
        :class="{
            'bg-primary': on,
            'bg-[#EEEFF2]': !on,
            'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
        }"
        class="relative inline-flex shrink-0 {{ $sizes[$size] }} rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50"
    >
        <span
            aria-hidden="true"
            :class="on ? 'translate-x-full' : 'translate-x-0'"
            class="pointer-events-none inline-block {{ $dotSizes[$size] }} bg-white rounded-full shadow transform transition duration-200"
        ></span>
    </button>

    @if ($label)
        <span class="text-sm text-black select-none">
            {{ $label }}
        </span>
    @endif
</div>

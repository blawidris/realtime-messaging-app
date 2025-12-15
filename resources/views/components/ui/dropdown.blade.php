@php
$alignment = match ($align) {
'left' => 'left-0 origin-top-left',
'top' => 'bottom-full origin-bottom',
default => 'right-0 origin-top-right',
};

$widthClass = match ($width) {
'48' => 'w-48',
'56' => 'w-56',
'64' => 'w-64',
default => $width,
};
@endphp

<div
    x-data="{ open: false }"
    {{ $attributes->merge([
        'class' => 'relative inline-block text-left'
    ]) }}>
    {{-- Trigger --}}
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    {{-- Dropdown --}}
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute z-50 mt-2 {{ $widthClass }} rounded-md shadow-lg bg-white ring-1 ring-black/5 {{ $alignment }}"
        style="display: none;">
        <div class="py-1">
            {{ $content }}
        </div>
    </div>
</div>
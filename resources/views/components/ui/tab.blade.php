@props([
    'name',
    'icon' => null,
    'variant' => 'default',
])

@php
$base =
    'transition-all flex items-center gap-2 focus:outline-none';

$variantClasses = match ($variant) {
    'outline' => 'px-4 py-2 rounded-md border',
    'pill' => 'px-4 py-3 w-full',
    default => 'pb-3 border-b-2',
};

$activeClasses = match ($variant) {
    'outline' => 'border-primary text-primary bg-primary/5',
    'pill' => 'bg-[#F8FCFF] text-primary border-l-2 border-primary',
    default => 'border-primary text-primary',
};

$inactiveClasses = match ($variant) {
    'outline' => 'border-transparent text-muted hover:border-gray-200',
    'pill' => 'text-muted hover:bg-[#F8FCFF] hover:text-primary',
    default => 'border-transparent text-muted hover:text-primary',
};
@endphp

<li>
    <button
        @click="activeTab = '{{ $name }}'"
        class="{{ $base }} {{ $variantClasses }}"
        :class="activeTab === '{{ $name }}'
            ? '{{ $activeClasses }}'
            : '{{ $inactiveClasses }}'"
    >
        @if ($icon)
            {!! $icon !!}
        @endif

        <span>{{ $slot }}</span>
    </button>
</li>

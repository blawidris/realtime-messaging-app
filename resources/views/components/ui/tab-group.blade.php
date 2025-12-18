@props([
    'active' => null,
    'direction' => 'default', // default | horizontal
    'class' => '',
])

@php
$layoutClass = match ($direction) {
    // Tabs left, panels right
    'horizontal' => 'flex gap-8 items-start',

    // Tabs top, panels below
    default => 'space-y-6',
};
@endphp

<div
    x-data="{ activeTab: '{{ $active }}' }"
    class="{{ $layoutClass }} {{ $class }}"
>
    {{ $slot }}
</div>

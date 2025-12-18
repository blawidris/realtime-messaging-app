@props([
    'active' => null,
    'variant' => 'outline',   // default | outline | pill
    'direction' => 'horizontal', // horizontal | vertical
    'class' => '',
])

@php
$baseWrapper = 'overflow-x-auto';
$directionClass = $direction === 'vertical'
    ? 'flex flex-col gap-2'
    : 'flex gap-8 whitespace-nowrap';

$variantClasses = match ($variant) {
    'outline' => 'border border-gray-200 rounded-lg p-2',
    'pill' => 'bg-white rounded-xl',
    default => '',
};

$classes = implode(' ', [
    $variantClasses,
    $class,
]);
@endphp

<div
    x-init="
        if (typeof activeTab === 'undefined') {
            activeTab = '{{ $active }}'
        }
    "
    {{ $attributes->merge(['class' => $classes]) }}
>
    <ul class="{{ $directionClass }} text-[15px] font-medium">
        {{ $slot }}
    </ul>
</div>

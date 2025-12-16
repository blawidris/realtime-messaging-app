@props([
    'type' => 'button',
    'size' => 'md',
    'variant' => 'primary',
    'disabled' => false,
])

@php
$baseClasses = implode(' ', [
    'inline-flex items-center justify-center font-medium rounded-xl',
    'transition-all duration-200',
    'focus:outline-none focus:ring-2 focus:ring-offset-2',
    'disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:scale-100',
]);

$sizes = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];

$variants = [
    'primary' => implode(' ', [
        'text-white',
        'bg-[radial-gradient(circle,_#58A3FF_0%,_#407BFF_100%)]',
        'border border-black/10',
        'shadow-[0_4px_7px_-5px_#828282,_0_0_2px_#E7E7E7]',
        'hover:shadow-[0_6px_12px_-5px_#828282,_0_0_4px_#E7E7E7]',
        'active:scale-[0.98]',
        'focus:ring-primary/50',
    ]),

    'danger' => implode(' ', [
        'text-white',
        'bg-[radial-gradient(circle,_#FF466D_0%,_#D80027_100%)]',
        'border border-black/10',
        'shadow-[0_4px_7px_-5px_#828282,_0_0_2px_#E7E7E7]',
        'hover:shadow-[0_6px_12px_-5px_#828282,_0_0_4px_#E7E7E7]',
        'active:scale-[0.98]',
        'focus:ring-red-500/40',
    ]),

    'outlined' => implode(' ', [
        'text-gray-800',
        'bg-transparent',
        'border border-gray-300',
        'shadow-[0_4px_7px_-5px_#828282,_0_0_2px_#E7E7E7]',
        'hover:bg-gray-100',
        'hover:shadow-[0_6px_12px_-5px_#828282,_0_0_4px_#E7E7E7]',
        'active:scale-[0.98]',
        'focus:ring-gray-400/40',
    ]),
];

$classes = implode(' ', [
    $baseClasses,
    $sizes[$size] ?? $sizes['md'],
    $variants[$variant] ?? $variants['primary'],
]);
@endphp

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled aria-disabled=true' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>

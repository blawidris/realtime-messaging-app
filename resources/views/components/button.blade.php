{{-- resources/views/components/radical-button.blade.php --}}

@props([
'type' => 'button',
'size' => 'md',
'variant' => 'primary',
'onclick' => null,
])

@php
$sizeClasses = [
'sm' => 'px-4 py-2 text-sm',
'md' => 'px-6 py-3 text-base',
'lg' => 'px-8 py-4 text-lg',
];

$variantClass = match($variant) {
'primary' => 'btn-primary',
'danger' => 'btn-danger',
'outlined' => 'btn-outlined',
default => 'btn-primary',
};

$baseClasses = 'flex items-center justify-center font-medium rounded-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/50';
@endphp

<button
    type="{{ $type }}"
    @if($onclick) onclick="{{ $onclick }}" @endif
    {{ $attributes->merge([
        'class' => "$variantClass $baseClasses {$sizeClasses[$size]}"
    ]) }}>
    {{ $slot }}
</button>

<style>
    /* Primary Variant - Radial Gradient (Blue) */
    .btn-primary {
        background: radial-gradient(circle, #58A3FF 0%, #407BFF 100%);
        border: 1px solid #333333/20;
        color: white;
        box-shadow:
            0px 4px 7px -5px #828282,
            0px 0px 2px 0px #E7E7E7;
    }

    .btn-primary:hover {
        box-shadow:
            0px 6px 12px -5px #828282,
            0px 0px 4px 0px #E7E7E7;
    }

    .btn-primary:active {
        transform: scale(0.98);
    }

    /* Danger Variant - Red Gradient */
    .btn-danger {
        background: radial-gradient(circle, #FF466D 0%, #D80027 100%);
      
        color: white;
        box-shadow:
            0px 4px 7px -5px #828282,
            0px 0px 2px 0px #E7E7E7;
    }

    .btn-danger:hover {
        box-shadow:
            0px 6px 12px -5px #828282,
            0px 0px 4px 0px #E7E7E7;
    }

    .btn-danger:active {
        transform: scale(0.98);
    }

    /* Outlined Variant - Transparent with Border */
    .btn-outlined {
        background: transparent;
        border: 1px solid #333333;
        color: #333333;
        box-shadow:
            0px 4px 7px -5px #828282,
            0px 0px 2px 0px #E7E7E7;
    }

    .btn-outlined:hover {
        background: rgba(51, 51, 51, 0.05);
        box-shadow:
            0px 6px 12px -5px #828282,
            0px 0px 4px 0px #E7E7E7;
    }

    .btn-outlined:active {
        transform: scale(0.98);
    }
</style>
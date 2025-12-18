@props(['name', 'class' => null])

<div
    x-show="activeTab === '{{ $name }}'"
    x-transition.opacity
    class="{{ $class }}"
>
    {{ $slot }}
</div>
@props(['name'])

<div
    x-show="activeTab === '{{ $name }}'"
    x-transition.opacity
    class="mt-6">
    {{ $slot }}
</div>
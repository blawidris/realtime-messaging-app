@props([
'active' => null,
'class' => '',
])

<div
    x-init="
        if (typeof activeTab === 'undefined') {
            activeTab = '{{ $active }}'
        }
    "
    class="{{ $class }}">
    {{ $slot }}
</div>
@props(['name', 'icon' => null, 'active' => false])

<li>
    <button 
        @click="activeTab = '{{ $name }}'" 
        class="tab-btn pb-3 border-b-2 transition-all flex items-center gap-2"
        :class="activeTab === '{{ $name }}' 
            ? 'text-primary border-primary' 
            : 'text-muted border-transparent'"
    >
        @if ($icon)
            {!! $icon !!}
        @endif

        <span>{{ $slot }}</span>
    </button>
</li>

@props([
'columns' => [], // dynamic columns
'rows' => [], // dynamic rows
'fetchUrl' => null,
'showSearch' => true,
'showFilter' => true,
'showActions' => false,
])

<div x-data="dataTable({
        fetchUrl: '{{ $fetchUrl }}',
        initialRows: @js($rows),
        columns: @js($columns),
        showActions: @js($showActions)
    })"
    class="bg-white rounded-xl border border-gray-200 py-10">

    {{-- Header --}}
    <div class="flex items-center sm:justify-end px-6 py-4 border-b border-gray-100 gap-5 flex-wrap sm:flex-nowrap">
        <div class="flex items-center gap-4">
            @if($showSearch)
            <div class="relative w-full sm:w-72">
                <input
                    x-model.debounce.500ms="search"
                    type="text"
                    placeholder="Search"
                    class="indent-6 py-2 border border-[#EBEDF0] bg-[#FAFAFA] rounded-lg text-sm focus:ring-0 focus:border-gray-300 w-full" />
                <svg class="absolute left-3 top-3 size-5 text-muted"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" />
                </svg>
            </div>
            @endif
        </div>

        @if($showFilter)
        <div class="relative w-full max-w-[9rem]" x-data="{ open: false }">
            <button
                @click="open = !open"
                class="flex items-center justify-between gap-2 px-4 py-3 border border-[#EBEDF0] rounded-lg text-sm text-muted w-full bg-[#FAFAFA]">
                Filter by
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.584l3.71-4.353a.75.75 0 1 1 1.14.976l-4.25 5a.75.75 0 0 1-1.14 0l-4.25-5a.75.75 0 0 1 .02-1.06Z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50">
                {{ $filters ?? '' }}
            </div>
        </div>
        @endif
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-muted">
                <tr class="border-b border-gray-100">
                    <template x-for="column in columns" :key="column.key">
                        <th class="px-6 py-4 font-medium">
                            <div class="flex items-center gap-2">
                                <span x-text="column.label"></span>
                                <span class="text-muted cursor-pointer">
                                    <i class="bi bi-arrow-down-up text-xs"></i>
                                </span>
                                
                            </div>
                        </th>
                    </template>

                    @if ($showActions)

                    <th class="px-6 py-4 text-right">Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                <template x-for="row in rows" :key="row.id">
                    <tr class="border-b border-[#EBEDF0]">
                        <template x-for="column in columns" :key="column.key">
                            <td class="px-6 py-4">

                                <!-- Talent cell -->
                                <template x-if="column.type === 'talent'">
                                    <div class="flex items-center gap-3">
                                        <img :src="row.avatar" class="w-8 h-8 rounded-full">
                                        <a href="#" class="text-primary font-medium" x-text="row.name"></a>
                                    </div>
                                </template>

                                <!-- Text -->
                                <template x-if="column.type === 'text'">
                                    <span x-text="row[column.key]"></span>
                                </template>

                                <!-- Money -->
                                <template x-if="column.type === 'money'">
                                    <span x-text="`${row[column.key].toLocaleString()}`"></span>
                                </template>

                                <!-- Date -->
                                <template x-if="column.type === 'date'">
                                    <span x-text="row[column.key]"></span>
                                </template>

                                <!-- Status badge -->
                                <template x-if="column.type === 'status'">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border capitalize"
                                        :class="statusClasses(row[column.key])"
                                        x-text="row[column.key]"></span>
                                </template>

                            </td>
                        </template>

                        <!-- Actions (UI-only) -->
                        <td class="px-6 py-4 text-right">
                            {{ $actions ?? '' }}
                        </td>
                    </tr>
                </template>
            </tbody>

        </table>
    </div>

    {{-- Loader --}}
    <div x-show="loading" class="py-6 text-center text-sm text-gray-400">
        Loading more…
    </div>

    {{-- Infinite scroll trigger --}}
    <div x-intersect="loadMore"></div>
</div>

@push("scripts")
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dataTable', ({
            fetchUrl,
            initialRows,
            columns,
            showActions
        }) => ({
            rows: initialRows || [],
            columns: columns || [],
            page: 1,
            loading: false,
            search: '',
            statusClasses(status) {
                return {
                    scheduled: 'bg-blue-50 text-blue-600 border border-blue-200',
                    completed: 'bg-green-50 text-green-600 border border-green-200',
                    failed: 'bg-red-50 text-red-600 border border-red-200',
                } [status] ?? 'bg-gray-50 text-gray-600 border border-gray-200';
            },

            async loadMore() {
                if (this.loading || !fetchUrl) return;

                this.loading = true;
                this.page++;

                const response = await fetch(
                    `${fetchUrl}?page=${this.page}&search=${this.search}`
                );

                const data = await response.json();

                this.rows.push(...data.data);
                this.loading = false;
            },

            $watch: {
                search() {
                    this.page = 1;
                    this.fetchFresh();
                }
            },

            async fetchFresh() {
                this.loading = true;

                const response = await fetch(
                    `${fetchUrl}?search=${this.search}`
                );

                const data = await response.json();
                this.rows = data.data;

                this.loading = false;
            }
        }));
    });
</script>
@endpush
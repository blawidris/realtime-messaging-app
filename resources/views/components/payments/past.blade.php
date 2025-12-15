<x-ui.table
    :columns="[
    [
        'key' => 'talent',
        'label' => 'Talent',
        'type' => 'talent', // custom renderer
    ],
    [
        'key' => 'type',
        'label' => 'Type',
        'type' => 'text',
    ],
    [
        'key' => 'amount',
        'label' => 'Payment amount',
        'type' => 'money',
    ],
    [
        'key' => 'payment_date',
        'label' => 'Payment date',
        'type' => 'date',
    ],
    [
        'key' => 'payment_method',
        'label' => 'Payment method',
        'type' => 'text',
    ],
   
    [
        'key' => 'status',
        'label' => 'Status',
        'type' => 'status',
    ],
]"
    :rows="$pastPayments"
    :show-search="true"
    :show-filter="true">
    <x-slot name="actions">
        <x-ui.dropdown>
            <x-slot name="trigger">
                <button class="p-2 rounded-full hover:bg-[#EBEDF0]">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </x-slot>
            <x-slot name="content">
                <a href="#" class="text-sm block p-2.5 hover:bg-[#F5F7FA] hover:text-primary">View</a>
                <a href="#" class="text-sm block p-2.5 hover:bg-[#F5F7FA] hover:text-primary">Download</a>
            </x-slot>
        </x-ui.dropdown>
    </x-slot>
</x-ui.table>
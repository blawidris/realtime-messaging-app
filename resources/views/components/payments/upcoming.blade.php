<x-ui.table
    :columns="[
    [
        'key' => 'talent',
        'label' => 'Talent',
        'type' => 'talent', // custom renderer
    ],
    [
        'key' => 'role',
        'label' => 'Role',
        'type' => 'text',
    ],
    [
        'key' => 'project',
        'label' => 'Project',
        'type' => 'text',
    ],
    [
        'key' => 'amount',
        'label' => 'Amount',
        'type' => 'money',
    ],
    [
        'key' => 'currency',
        'label' => 'Currency',
        'type' => 'text',
    ],
    [
        'key' => 'scheduled_date',
        'label' => 'Scheduled date',
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
    :rows="$payments"
    fetch-url=""
    :show-search="true"
    :show-filter="true">
    <x-slot name="filters">
        <label class="block text-sm mb-2">
            <input type="checkbox" class="mr-2"> Paid
        </label>
        <label class="block text-sm">
            <input type="checkbox" class="mr-2"> Deferred
        </label>
    </x-slot>

</x-ui.table>
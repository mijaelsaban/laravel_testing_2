<div>
    <x-search></x-search>
    <x-date-picker/>
    <x-table>
        <x-slot name="title">Order</x-slot>
        <x-slot name="head">
            <tr>
                <th>
                <th colspan="15">
                    Showing {{ $perPage }} - from - {{ $orders->total() }}
                </th>
                </th>
            </tr>
            <th wire:click="sortBy('provider_id')">
                <x-table.heading> #</x-table.heading>
            </th>
            <th>
                <x-table.heading></x-table.heading>
                <select wire:model="selectedProvider" name="" id="" style="width: 110px;">
                    <option value="">Providers</option>
                    <option value="1">Stripe</option>
                    <option value="2">Paypal</option>
                    <option value="3">Sofort</option>
                    <option value="4">Stripe payment module</option>
                </select>
            </th>
            <th wire:click="sortBy('reference')">
                <x-table.heading sortable :direction="$sortField === 'reference'? $sortAsc : true"> Reference
                </x-table.heading>
            </th>
            <th>
                <x-table.heading sortable :direction="$sortField === 'gross'? $sortAsc : true"> Order id </x-table.heading>
            </th>
            <th wire:click="sortBy('gross')">
                <x-table.heading sortable :direction="$sortField === 'gross'? $sortAsc : true"> Amount </x-table.heading>
            </th>
            <th wire:click="sortBy('fee')">
                <x-table.heading sortable :direction="$sortField === 'fee'? $sortAsc : true"> Payment Reference</x-table.heading>
            </th>
            <th wire:click="sortBy('net')">
                <x-table.heading sortable :direction="$sortField === 'net'? $sortAsc : true"> Total paid</x-table.heading>
            </th>
            <th wire:click="sortBy('customer_facing_amount')">
                <x-table.heading sortable :direction="$sortField === 'customer_facing_amount'? $sortAsc : true"> Customer
                </x-table.heading>
            </th>
            <th wire:click="sortBy('customer_name')">
                <x-table.heading sortable :direction="$sortField === 'customer_name'? $sortAsc : true"> Stripe
                </x-table.heading>
            </th>
        </x-slot>
        <x-slot name="body">
            @forelse($orders as $order)
                <x-table.row>
                    <x-table.cell> {{ $perPage * ($page - 1) + $loop->iteration }} </x-table.cell>
                    <x-table.cell>  {{ $order->payment }} </x-table.cell>
                    <x-table.cell class="text-gray"> {{ $order->reference }} </x-table.cell>
                    <x-table.cell class="text-gray"> {{ $order->id_order }} </x-table.cell>
                    <x-table.cell> {{ $order->total_paid }} {{ $order->currency->sign ?? '' }} </x-table.cell>
                    <x-table.cell> {{ $order->id_stripe ?? $order->id_transaction  }} </x-table.cell>
                    <x-table.cell> {{ $order->amount ?? $order->total_paid }} </x-table.cell>
                    <x-table.cell> {{ $order->lastname ?? '-' }} {{ $order->firstname ?? '-' }} </x-table.cell>
                    <x-table.cell class="text-gray"> {{ $order->date_add }} </x-table.cell>
                </x-table.row>
            @empty
                <tr>
                    <td class="py-5 bg-white text-center text-black-50 font-weight-bolder" colspan="15">
                        <x-icons.inbox></x-icons.inbox>
                        No results found...
                    </td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>
    <x-pagination :model="$orders"></x-pagination>
</div>

<div>
    <x-search></x-search>
    <x-date-picker/>
    <x-table>
        <x-slot name="title">Transactions</x-slot>
        <x-slot name="head">
            <tr>
                <th>
                    <th colspan="15">
                        Showing {{ $perPage }} - from - {{ $transactions->total() }}
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
                </select>
            </th>
            <th wire:click="sortBy('reference')">
                <x-table.heading sortable :direction="$sortField === 'reference'? $sortAsc : true"> Reference
                </x-table.heading>
            </th>
            <th>
                <x-table.heading></x-table.heading>
                <select wire:model="selectedType" name="" id="" style="width: 90px;">
                    <option value="">Types</option>
                    <option value="charge">Charge</option>
                    <option value="refund">Refund</option>
                </select>
            </th>
            <th wire:click="sortBy('gross')">
                <x-table.heading sortable :direction="$sortField === 'gross'? $sortAsc : true"> Amount
                </x-table.heading>
            </th>
            <th wire:click="sortBy('fee')">
                <x-table.heading sortable :direction="$sortField === 'fee'? $sortAsc : true"> Fee</x-table.heading>
            </th>
            <th wire:click="sortBy('net')">
                <x-table.heading sortable :direction="$sortField === 'net'? $sortAsc : true"> Net</x-table.heading>
            </th>
            <th wire:click="sortBy('customer_facing_amount')">
                <x-table.heading sortable :direction="$sortField === 'customer_facing_amount'? $sortAsc : true"> FX amount
                </x-table.heading>
            </th>
            <th wire:click="sortBy('customer_name')">
                <x-table.heading sortable :direction="$sortField === 'customer_name'? $sortAsc : true"> Name
                </x-table.heading>
            </th>
            <th wire:click="sortBy('customer_name')">
                <x-table.heading sortable :direction="$sortField === 'customer_name'? $sortAsc : true"> Email
                </x-table.heading>
            </th>
            <th wire:click="sortBy('order_reference')">
                <x-table.heading sortable :direction="$sortField === 'order_reference'? $sortAsc : true"> Order ref
                </x-table.heading>
            </th>
            <th wire:click="sortBy('amount')">
                <x-table.heading sortable :direction="$sortField === 'amount'? $sortAsc : true"> Order amount
                </x-table.heading>
            </th>
            <th>
                <x-table.heading></x-table.heading>
                <select wire:model="selectedStatus" name="" id="" style="width: 90px;">
                    <option value="">Status</option>
                    <option value="NOT FOUND">Not found</option>
                    <option value="DIFFERENCE">Difference</option>
                    <option value="MATCHED">Matched</option>
                </select>
            </th>
            <th wire:click="sortBy('transacted_at')">
                <x-table.heading sortable :direction="$sortField === 'transacted_at' ? $sortAsc : true"> Transaction
                </x-table.heading>
            </th>
        </x-slot>
        <x-slot name="body">
            @forelse($transactions as $transaction)
                <x-table.row>
                    <x-table.cell> {{ $perPage * ($page - 1) + $loop->iteration }} </x-table.cell>
                    <x-table.cell>  {{ $transaction->provider->getSvg() }} </x-table.cell>
                    <x-table.cell class="text-gray"> {{ $transaction->transaction_reference }} </x-table.cell>
                    <x-table.cell
                        class="text-capitalize"><span
                            class="badge {{ $transaction->type_color }}"> {{ $transaction->type }} </span>
                    </x-table.cell>
                    <x-table.cell> {{ $transaction->gross }} {{ $transaction->currency->sign ?? '' }} </x-table.cell>
                    <x-table.cell> {{ $transaction->fee }} {{ $transaction->currency->sign ?? '' }} </x-table.cell>
                    <x-table.cell> {{ $transaction->net }} {{ $transaction->currency->sign ?? '' }} </x-table.cell>
                    <x-table.cell> {{ $transaction->customer_facing_amount ?? '-' }} {{ $transaction->customerFacingCurrency->sign ?? '' }} </x-table.cell>
                    <x-table.cell class="text-gray"
                                  title="{{ $transaction->customer_name }}"> {{ \Illuminate\Support\Str::limit($transaction->customer_name ?? '-', 12) }} </x-table.cell>
                    <x-table.cell class="text-gray"
                                  title="{{ $transaction->customer_email }}"> {{ \Illuminate\Support\Str::limit($transaction->customer_email ?? '-', 12) }} </x-table.cell>
                    <x-table.cell
                        class="text-gray"> @if($transaction->type === 'charge') {{ $transaction->order_reference ?? '-' }} @else {{ $transaction->refunds_order_reference ?? '-' }} @endif</x-table.cell>
                    <x-table.cell
                        class="text-gray"> @if($transaction->type === 'charge') {{ number_format($transaction->order_value, 2) ?? '-' }} @else {{ number_format($transaction->amount, 2) ?? '-' }} @endif</x-table.cell>
                    <x-table.cell class="text-gray"><span
                            class="badge {{ $transaction->status ? $transaction->statusColor($transaction->status) : '-' }}"> {{ $transaction->status }} </span>
                    </x-table.cell>
                    <x-table.cell class="text-gray"> {{ $transaction->transacted_at }} </x-table.cell>
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
    <x-pagination :model="$transactions"></x-pagination>
</div>

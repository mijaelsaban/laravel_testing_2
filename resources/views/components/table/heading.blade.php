@props([
    'sortable' => null,
    'direction' => null,
])

    @unless($sortable)
        <span>{{ $slot }}</span>
    @else
            <span>
             {{ $slot }}
            </span>

            <button class="btn btn-icon">
                @if($direction === true)
                    <span class="p-2 text-gray cursor-pointer">
                         <x-icons.chevron-up></x-icons.chevron-up>
                    </span>
                @elseif($direction === false)
                    <x-icons.chevron-down></x-icons.chevron-down>
                @else
                    <span class="p-2 text-gray cursor-pointer">
                        <x-icons.chevron-up></x-icons.chevron-up>
                    </span>
                @endif
            </button>
    @endunless

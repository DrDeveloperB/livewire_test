<div>

    <h1 class="text-3xl">Support Ticket</h1>

    <div class="my-2">
        @foreach($tickets as $ticket)
            <div wire:click="$emit('ticketSelected', {{ $ticket->id }})" class="rounded border shadow p-3 my-2 {{ $active === $ticket->id ? 'bg-green-200' : '' }}">
                <p class="text-grey-800">       {{--            break-words--}}
                    {{ $ticket->id }} : {{ $ticket['question'] }}
                </p>
            </div>
        @endforeach
    </div>

{{--{{ $tickets->links() }}--}}
{{--    {{ $tickets->links('pagination-links') }}--}}

</div>

<div>

    <h1 class="text-3xl">Support Ticket</h1>

    <livewire:ticket-add>

    <div class="my-2">
        @foreach($tickets as $ticket)
            <div class="rounded border shadow p-3 my-2 {{ $active === $ticket->id ? 'bg-green-200' : '' }}">

                <div class="flex justify-between my-2">
                    <div class="flex">
                        <p class="font-bold text-lg ">
                            {{ $ticket->id }} :
                            {{--                            {{ dd($comment->creator) }}--}}
                            {{ $ticket->creator->name }}
                            {{--                            {{ $comment->creator->created_at }}--}}
                        </p>
                        <p class="mx-3 py-1 text-xs text-grey-500 font-semibold">
                            {{ $ticket->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <svg wire:click="$emit('swalConfirm', 'remove', {{ $ticket->id }}, '삭제 확인', '{!! str_replace('#{ticketId}', $ticket->id, '#{ticketId}번 글을 삭제하시겠습니까?') !!}')" class="h-5 w-5 text-red-300 cursor-pointer hover:text-red-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>

                <div wire:click="$emit('ticketSelected', {{ $ticket->id }})">
                    <p class="text-grey-800">
                        {{ $ticket['question'] }}
                    </p>
                    @if($ticket->image)
                        <p>
                            <img src="{{ $ticket->imagePath }}" alt="">
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($tickets)
{{--{{ $tickets->links() }}--}}
        {{ $tickets->links('pagination-links') }}
{{--    {{ $tickets->withPath('home')->links('pagination-links') }}--}}
    @endif

</div>



@push('scripts')
    <script>
        // jQuery $(document).ready
        // DOMContentLoaded 또는 livewire:load
        document.addEventListener("livewire:load", () => {

            // window.livewire.on 또는 @this.on
            window.livewire.on('swalSuccess', (obj) => {
                Swal.fire(
                    {
                        title: obj['title'],
                        text: obj['text'],
                        icon: 'success',
                        toast: true,
                        position: 'top',
                        timer: 1000,
                        width: '500px',
                        showCancelButton: false,
                        showConfirmButton: false,
                    }
                );
            });

            @this.on('swalConfirm', (callback, contentId, title, text) => {
                Swal.fire({
                    title: title,
                    text: text,     // text, newText
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '삭제',
                    cancelButtonColor: '#aaa',
                    cancelButtonText: '취소',
                })
                    .then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                        @this.call(callback, contentId);
                            // success response
                            // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                        } else {
                            // Swal.fire({
                            //     title: 'Operation Cancelled!',
                            //     icon: 'success'
                            // });
                        }
                    });
            });

        });
    </script>
@endpush

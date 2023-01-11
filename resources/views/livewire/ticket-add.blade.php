
<div class="mt-4">
    <div>
        <section>
            @if($image)
                <img src="{{ $image }}" id="ticketImageView" alt="">
            @endif
            <input type="file" id="ticketImage" wire:change="$emit('ticketFileChosen')">
        </section>
    </div>

    <div class="my-2">
        <form wire:submit.prevent="addTicket" class="flex">
            <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="What's your mind" wire:model.debounce.500ms="newTicket">

            <div class="py-2">
                <button type="submit" class="p-2 bg-blue-500 w-20 rounded shadow text-white">
                    Add
                </button>
            </div>
        </form>

        @error('newTicket') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
</div>



@push('scripts')
    <script>
        // jQuery $(document).ready
        // DOMContentLoaded 또는 livewire:load
        document.addEventListener("livewire:load", () => {

            window.livewire.on('ticketFileChosen', () => {
                let inputField = document.getElementById('ticketImage');
                let file = inputField.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onloadend = () => {
                        window.livewire.emit('ticketFileUpload', reader.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    let imageView = document.getElementById('ticketImageView');
                    imageView.parentNode.removeChild(imageView);
                }
            });

        });
    </script>
@endpush

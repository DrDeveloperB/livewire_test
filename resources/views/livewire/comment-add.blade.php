
<div class="mt-4">
{{--    @if (session()->has('message'))--}}
{{--        <div class="alert-success my-2 p-3 bg-green-300 text-green-800 rounded shadow-sm">--}}
{{--            {{ session('message') }}--}}
{{--        </div>--}}
{{--    @endif--}}

    <div>
        <section>
            @if($image)
                <img src="{{ $image }}" id="imageView_comment" alt="">
            @endif
            <input type="file" id="image_comment" wire:change="$emit('fileChosen')">
{{--            {{ $image }}--}}
{{--            <input type="file" id="image" wire:model="image">--}}
        </section>
    </div>

    <div class="my-2">
        <form wire:submit.prevent="addComment" class="flex">
            <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="What's your mind" wire:model.debounce.500ms="newComment">

            <div class="py-2">
                <button type="submit" class="p-2 bg-blue-500 w-20 rounded shadow text-white">
                    Add
                </button>
{{--                <button class="p-2 bg-blue-500 w-20 rounded shadow text-white" wire:click="addComment">--}}
{{--                    Add--}}
{{--                </button>--}}
            </div>
        </form>

{{--
오류 메세지 하나씩 표시
--}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="text-red-500 text-xs">{{ $error }}</span>
                @break
            @endforeach
        @endif

{{--        @error('ticketId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror--}}
{{--        @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror--}}
    </div>
</div>



@push('scripts')
    <script>
        // // jQuery fadeout
        // function fadeOutEffect(el, mode) {
        //     let fadeTarget = document.querySelector(el);
        //     let ms = mode === 'slow' ? 200 : 50;
        //     let fadeEffect = setInterval(function () {
        //         if (!fadeTarget.style.opacity) {
        //             fadeTarget.style.opacity = 1;
        //         }
        //         if (fadeTarget.style.opacity > 0) {
        //             fadeTarget.style.opacity -= 0.1;
        //         } else {
        //             clearInterval(fadeEffect);
        //             fadeTarget.parentNode.removeChild(fadeTarget);
        //         }
        //     }, ms);
        // }

        // jQuery $(document).ready
        // DOMContentLoaded 또는 livewire:load
        document.addEventListener("livewire:load", () => {
            // window.livewire.on 또는 @this.on
            window.livewire.on('alert_remove', () => {
                setTimeout(function(){
                    fadeOutEffect('.alert-success', 'fast');
                }, 3000); // 3 secs
            });

            // window.livewire.on('swalSuccess', (obj) => {
            //     Swal.fire(
            //         {
            //             title: obj['title'],
            //             text: obj['text'],
            //             icon: 'success',
            //             toast: true,
            //             position: 'top',
            //             timer: 1000,
            //             width: '500px',
            //             showCancelButton: false,
            //             showConfirmButton: false,
            //         }
            //     );
            // });

        // @this.on('swalConfirm', (callback, commentId, title, text) => {
        //     // let newText = text.replaceAll('#{commentId}', commentId);
        //
        //     Swal.fire({
        //         title: title,
        //         text: text,     // text, newText
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         confirmButtonText: '삭제',
        //         cancelButtonColor: '#aaa',
        //         cancelButtonText: '취소',
        //     })
        //         .then((result) => {
        //             //if user clicks on delete
        //             if (result.value) {
        //                 // calling destroy method to delete
        //             @this.call(callback, commentId);
        //                 // success response
        //                 // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
        //             } else {
        //                 // Swal.fire({
        //                 //     title: 'Operation Cancelled!',
        //                 //     icon: 'success'
        //                 // });
        //             }
        //         });
        // });

            window.livewire.on('fileChosen', () => {
                let inputField = document.getElementById('image_comment');
                let file = inputField.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onloadend = () => {
                        // window.livewire.emit('fileUpload', {"rrr" : reader.result});
                        window.livewire.emit('fileUpload', reader.result);
                        // console.log(reader.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    let imageView = document.getElementById('imageView_comment');
                    imageView.parentNode.removeChild(imageView);
                }
            });

            {{--Livewire.on('swalConfirm', e => {--}}
            {{--    --}}{{--if (!confirm("{{ trans('global.areYouSure') }}")) {--}}
            {{--    --}}{{--    return--}}
            {{--    --}}{{--}--}}
            {{--    @this[e.callback](...e.argv)--}}
            {{--})--}}
        });
    </script>
@endpush

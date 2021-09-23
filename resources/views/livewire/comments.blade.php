
<div>       {{--    class="flex justify-center w-6/12"--}}

{{--    {{ dd($comments[0]->body) }}--}}

    <h1 class="text-3xl">Comment</h1>       {{--        my-10--}}

{{--
댓글 입력시 update 메소드가 실행되면서 render 에서 DB 를 계속 조회하는 것을 방지
--}}
    <livewire:comment-add>

    <div class="my-2">
        @foreach($comments as $comment)
            <div class="rounded border shadow p-3 my-2">
                <div class="flex justify-between my-2">
                    <div class="flex">
                        <p class="font-bold text-lg ">
                            {{ $comment->id }} :
                            {{--                            {{ dd($comment->creator) }}--}}
                            {{ $comment->creator->name }}
                            {{--                            {{ $comment->creator->created_at }}--}}
                        </p>
                        <p class="mx-3 py-1 text-xs text-grey-500 font-semibold">
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>

                    {{--
                    wire:click="swalConfirm({{ $comment->id }}, '{{ $swalMsg['confirm']['title'] }}', '{{ $swalMsg['confirm']['text'] }}')"
                    wire:click="$emit('swalConfirm', 'remove', {{ $comment->id }}, '{{ $swalMsg['confirm']['title'] }}', '{{ $swalMsg['confirm']['text'] }}')"
                    wire:click="$emit('swalConfirm', 'remove', {{ $comment->id }}, '{{ $swalMsg['confirm']['title'] }}', '{!! str_replace('#{commentId}', $comment->id, $swalMsg['confirm']['text']) !!}')"
                    --}}
                    <svg wire:click="$emit('swalConfirm', 'remove', {{ $comment->id }}, '{{ $swalMsg['confirm']['title'] }}', '{!! str_replace('#{commentId}', $comment->id, $swalMsg['confirm']['text']) !!}')" class="h-5 w-5 text-red-300 cursor-pointer hover:text-red-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>

                <p class="text-grey-800">
                    {{--
                    object 또는 array 모두 사용 가능
                    gettype($comment) = object
                    --}}
                    {{--                    {{ $comment->body }}--}}
                    {{ $comment['body'] }}
                    <br>{{ mb_strlen($comment['body']) }}
                </p>
                @if($comment->image)
                    <p>
                        <img src="{{ $comment->imagePath }}" alt="">
                        {{--                    <img src="{{ $storagePath .'/'. $comment->image }}" alt="">--}}
                    </p>
                @endif
            </div>
        @endforeach
    </div>

{{--        {{ $comments->links() }}--}}
    {{ $comments->links('pagination-links') }}

</div>



<script>
    // alert()->success('SuccessAlert','Lorem ipsum dolor sit amet.');
</script>

@push('scripts')
    <script>
        // jQuery fadeout
        function fadeOutEffect(el, mode) {
            let fadeTarget = document.querySelector(el);
            let ms = mode === 'slow' ? 200 : 50;
            let fadeEffect = setInterval(function () {
                if (!fadeTarget.style.opacity) {
                    fadeTarget.style.opacity = 1;
                }
                if (fadeTarget.style.opacity > 0) {
                    fadeTarget.style.opacity -= 0.1;
                } else {
                    clearInterval(fadeEffect);
                    fadeTarget.parentNode.removeChild(fadeTarget);
                }
            }, ms);
        }

        // jQuery $(document).ready
        // DOMContentLoaded 또는 livewire:load
        document.addEventListener("livewire:load", () => {
            // window.livewire.on 또는 @this.on
            window.livewire.on('alert_remove', () => {
                setTimeout(function(){
                    fadeOutEffect('.alert-success', 'fast');
                }, 3000); // 3 secs
            });

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

        @this.on('swalConfirm', (callback, commentId, title, text) => {
            // let newText = text.replaceAll('#{commentId}', commentId);

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
                        @this.call(callback, commentId);
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

            window.livewire.on('fileChosen', () => {
               let inputField = document.getElementById('image');
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
                   let imageView = document.getElementById('imageView');
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

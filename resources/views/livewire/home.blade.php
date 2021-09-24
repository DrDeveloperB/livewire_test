@extends('layouts.base')

@section('content')

    <div class="w-full flex justify-center">

        <div class="w-10/12 my-10 flex">
            <div class="w-5/12 p-2 rounded border">
                <livewire:tickets>
            </div>

            <div class="w-7/12 p-2 rounded border mx-2">
                {{--<xmp>--}}
                {{--    {{ $comments = 'aaaaq' }}--}}
                {{--    {{ print_r($comments) }}--}}
                {{--</xmp>--}}

                {{--<livewire:comments :initialComments="$comments">--}}
{{--                <livewire:comments :initialComments="$comments">--}}
                <livewire:comments>
                {{--    @livewire('comments')--}}
            </div>
        </div>

    </div>

@endsection

<div>
     If your happiness depends on money, you will never be happy with yourself.
    <form enctype="multipart/form-data" method="post" action="{{ route('upload1') }}">
        <input type="file" name="upload_files">
        <button type="submit">upload_files</button>
    </form>

    <form enctype="multipart/form-data" method="post" action="{{ route('upload2') }}">
        {{ method_field('PUT') }}
        @csrf
        <input type="file" name="upload_files2">
        <button type="submit">upload_files2</button>
    </form>
{{--    {{ env('DB_DATABASE') }}--}}
</div>

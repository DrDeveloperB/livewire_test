<div class="mx-3 py-4">
    접속자 : {{ Illuminate\Support\Facades\Auth::user()->name }} 님
    <a class="mx-3 py-4 cursor-pointer" wire:click="logout">Logout</a>
</div>

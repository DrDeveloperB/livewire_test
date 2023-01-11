<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Emoji\Emoji;

class Tickets extends Component
{
    use WithPagination;

    protected $listeners = [
        'ticketSelected',
        'refreshTickets' => '$refresh',
    ];

    public $active;

    public function render(Request $request)
    {
//        $authAttributes = $request->user();
//        $authAttributes = Auth::user();
//        dd($authAttributes->email);

//        DB::enableQueryLog();
//        $test = SupportTicket::latest()      // order by primary key desc
//        ->get();
//        dd(getSqlWithBindings(DB::getQueryLog()));

        return view('livewire.tickets',
            [
//                'tickets' => SupportTicket::all(),
                'tickets' => SupportTicket::latest()      // order by primary key desc
//                ->get()
                ->paginate(3)      // view 호출 메소드에서만 사용 가능
                ->withPath('home')
            ]
        );
    }

    public function ticketSelected($ticketId)
    {
        $this->active = $ticketId;
    }

    public function remove($ticketId)
    {
        $ticket = SupportTicket::find($ticketId);
        $ticket->delete();
        Storage::disk('ticket')->delete($ticket->image);

        $msg = sprintf('%s %s',
            Str::replace('#{ticketId}', $ticketId, '#{ticketId}번 글이 삭제되었습니다.'),
            Emoji::CHARACTER_WEARY_FACE
        );

        $this->emit('swalSuccess',
            [
                'title' => '삭제 완료',
                'text' => $msg
            ]
        );
    }

}

<?php

namespace App\Http\Livewire;

use App\Models\SupportTicket;
use Livewire\Component;

class Tickets extends Component
{
    public $active;

    protected $listeners = ['ticketSelected'];

    public function render()
    {
        return view('livewire.tickets',
            [
//                'tickets' => SupportTicket::all(),
                'tickets' => SupportTicket::latest()      // order by primary key desc
                ->get()
//                ->paginate(3)      // view 호출 메소드에서만 사용 가능
            ]
        );
    }

    public function ticketSelected($ticketId)
    {
        $this->active = $ticketId;
    }
}

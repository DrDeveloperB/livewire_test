<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public function render(Request $request)
    {

//        dd( Auth::user());

        return view('livewire.home');
    }
}

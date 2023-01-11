<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.logout');
    }

    public function logout(Request $request)
    {
        Auth::logout();
//        $request->session()->regenerate();

//        dd($request->session()->all());

        return redirect('/');
//        return redirect(route('loginw'));
    }

}

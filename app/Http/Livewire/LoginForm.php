<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LoginForm extends Component
{
    public $form = [
        'email'   => '',
        'password'=> '',
    ];

    public function render(Request $request)
    {
//        dd($request->session()->all());

        return view('livewire.login-form');
    }

    public function submit(Request $request)
    {
//        $this->form = [
//            'email'   => 'a2@a.com',
//            'password'=> 'aaaa1111',
//        ];

        $this->validate([
            'form.email'    => 'required|email',
            'form.password' => 'required',
        ]);

//        Auth::attempt($this->form);

//        dd($this->form);
//        DB::enableQueryLog();
//        dd(Auth::attempt($this->form));
//        dd(Auth::check());
//        dd( Auth::user());
//        $request->session()->regenerate();
//        dd($request->session()->all());
//        dd(DB::getQueryLog()[0]);
//        dd(getSqlWithBindings(DB::getQueryLog()));
//        dd($request->expectsJson());

//        return redirect(route('home'));

        if (Auth::attempt($this->form)) {
            return redirect()->intended('home');
        }
    }
}

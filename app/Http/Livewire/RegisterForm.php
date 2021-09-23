<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class RegisterForm extends Component
{
    public $form = [
        'name'                  => '',
        'email'                 => '',
        'password'              => '',
        'password_confirmation' => '',
    ];

    public function render()
    {
        return view('livewire.register-form');
    }

    public function submit()
    {
        $this->validate([
            'form.name'     => 'required',
            'form.email'    => 'required|email',
            'form.password' => 'required|confirmed',
        ]);

        $this->form['password'] = bcrypt($this->form['password']);
//        dd($this->form);
        User::create($this->form);
        return redirect(route('loginw'));
    }

}

<?php

namespace App\Http\Livewire;

use App\Http\Controllers\AuthController;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestClass;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class RegisterForm extends Component
{
    public $form = [
        'name'                  => 'a6',
        'email'                 => 'a6@a.com',
        'password'              => 'aaaa1111',
        'password_confirmation' => 'aaaa1111',
    ];

    public function render()
    {
        return view('livewire.register-form');
    }

    public function submit()
    {

        $user = User::where('email', 'a2@a.com')->first();
        $token = $user->createToken('user_pp_token')->accessToken;

        // auto_increment 와 같은 unique number 필수
//        $tickets = new SupportTicket();
//        $ticket = $tickets->find(1);
//        $token = $ticket->createToken('ticket_pp_token')->accessToken;

//        $ticket = $tickets->find(1);
//        $token = $ticket->createToken('ticket_token')->plainTextToken;

        dd($token);

//        dd($this->form);

        $request = new RequestClass();
        $request->replace($this->form);
//        dd($request->name);

        $authController = new AuthController();
//        $response = $authController->index();
        $response = $authController->register($request);

//        $response = Http::post(
//            'https://bhc1909devjpaysale09.jasongroup.co.kr/api/registers',
//            [
//                'name' => $this->form['name'],
//                'email' => $this->form['email'],
//                'password' => $this->form['password'],
//            ]
//        );
        dd($response);

//        $this->validate([
//            'form.name'     => 'required',
//            'form.email'    => 'required|email',
//            'form.password' => 'required|confirmed',
//        ]);
//
//        $this->form['password'] = bcrypt($this->form['password']);
////        dd($this->form);
//        User::create($this->form);
//        return redirect(route('loginw'));
    }

}

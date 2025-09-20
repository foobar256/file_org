<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LoginForm extends Component
{
    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string|min:6')]
    public string $password = '';

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['name' => $this->name, 'password' => $this->password])) {
            request()->session()->regenerate();
            session()->flash('status', 'You are logged in.');
            return redirect()->intended('/');
        }

        $this->addError('name', 'Invalid credentials.');
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}

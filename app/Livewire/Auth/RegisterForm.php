<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterForm extends Component
{
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|string|min:6|confirmed')]
    public string $password = '';
    public string $password_confirmation = '';

    #[Validate('required|string')]
    public string $registration_hash = '';

    public function register()
    {
        $this->validate();

        $expected = (string) config('auth.registration_hash', '');

        if ($expected === '') {
            $this->addError('registration_hash', 'Registration hash is not configured.');
            return;
        }

        if (!hash_equals($expected, $this->registration_hash)) {
            $this->addError('registration_hash', 'Invalid registration hash.');
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'password' => $this->password, // hashed via cast in User model
        ]);

        Auth::login($user);
        request()->session()->regenerate();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}

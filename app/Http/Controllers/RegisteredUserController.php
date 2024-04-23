<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    public function show()
    {
        return view('auth.register');
    }

    public function create()
    {
        $attributes = request()->validate([
            'username' => ['required', 'unique:users', 'max:24', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)->letters()->numbers(), 'confirmed'],
        ]);

        $user = User::create($attributes);

        Auth::login($user, true);

        return redirect()->intended("/");
    }

}

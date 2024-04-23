<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{

    public function show()
    {
        return view('auth.login');
    }

    public function create()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $auth = Auth::attempt($attributes);

        if (!$auth) {
            throw ValidationException::withMessages([
                'email' => 'The provided email and password are incorrect. Please try again.',
            ]);
        }

        //Check if the email has been verified only in production
        if (App::environment('production')) {
            if (!auth()->user()->hasVerifiedEmail()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Your email has not been verified yet. Please check your email for the verification link.',
                ]);
            }
        }

        request()->session()->regenerate();

        return redirect()->intended('/');
    }

    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

}

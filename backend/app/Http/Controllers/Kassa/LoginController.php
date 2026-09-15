<?php

namespace App\Http\Controllers\Kassa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(
            [
                'employeeNr' => ['required', 'integer', 'min:1'],
                'password' => ['required', 'string'],
            ],
            [
                'employeeNr.required' => 'Medewerker nummer of wachtwoord niet ingevuld.',
                'employeeNr.integer' => 'Het medewerker nummer moet een getal zijn.',
                'password.required' => 'Medewerker nummer of wachtwoord niet ingevuld.',
            ],
        );

        $loginSuccessful = Auth::attempt([
            'id' => $credentials['employeeNr'],
            'password' => $credentials['password'],
        ]);

        if (! $loginSuccessful) {
            return back()
                ->withErrors([
                    'employeeNr' => 'Onbekende combinatie medewerker nummer en wachtwoord.',
                ])
                ->onlyInput('employeeNr');
        }

        $request->session()->regenerate();

        return redirect()->intended('/kassa/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('kassa.login');
    }
}
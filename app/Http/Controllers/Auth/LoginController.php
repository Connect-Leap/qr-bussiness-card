<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthenticationLogging;

class LoginController extends Controller
{

    use AuthenticationLogging;

    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $process = app('DoLogin')->execute($request->only('email', 'password'));

        if ($process['success']) {
            $request->session()->regenerate();

            session()->flash('success', $process['message']);

            $this->updateAuthLogging(auth()->id());

            return redirect()->intended('dashboard');
        } else {
            return back()->with('fail', $process['message']);
        }

    }

    public function logout(Request $request)
    {
        $this->updateAuthLogging(auth()->id(), false);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

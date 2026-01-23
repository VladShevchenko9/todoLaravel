<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $email = (string) $request->input('email', '');
        $password = (string) $request->input('password', '');

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            return redirect()->back()->with([
                'error' => 'User not found',
            ]);
        }

        if (! Hash::check($password, $user->password)) {
            return redirect()->back()->with([
                'error' => 'Invalid password',
            ]);
        }

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login.view');
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);
        Auth::login($user);

        return redirect()->route('home');
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function temp()
    {
        $user = User::query()->find(16);
        dd($user->tasks[1]);
    }
}

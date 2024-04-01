<?php

namespace App\Http\Controllers;

use App\Domain\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $user = User::query()->firstWhere('email', $email);
        if(Hash::check($password, $user->password)) {
            Auth::login($user);
            return response([
                'success' => true,
                'user' => Auth::user()
            ]);
        };
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response([
            'success' => true,
            'message' => 'Вы успешно вышли из системы'
        ]);
    }
}

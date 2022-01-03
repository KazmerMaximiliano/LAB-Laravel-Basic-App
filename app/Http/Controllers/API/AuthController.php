<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,null,id',
            'password' => 'required|string|min:6',
        ]);

        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['role_id'] = 2;

        User::create($attributes);

        return response()->json(['message' => 'Usuario creado correctamente.'], 200);
    }

    public function login(Request $request)
    {
        return 'HOLA MUDNO';
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}

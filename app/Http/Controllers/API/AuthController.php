<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;

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

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($user->first_name . ' ' . $user->last_name . ' - ' .date('l jS \of F Y h:i:s A'))->plainTextToken;
    }

    public function google(Request $request){
        $socialiteUser = Socialite::driver('google')->stateless()->userFromToken($request->token);

        $user = User::firstOrCreate(
            ['email' => $socialiteUser->email],
            [
                'email_verified_at' => now(),
                'name' => $socialiteUser->name,
                'role_id' => 2,
            ]
        );
        return $user->createToken($user->first_name . ' ' . $user->email . ' - ' .date('l jS \of F Y h:i:s A'))->plainTextToken;
    }

    public function facebook(Request $request){
        $socialiteUser = Socialite::driver('facebook')->stateless()->userFromToken($request->token);

        $user = User::firstOrCreate(
            ['email' => $socialiteUser->email],
            [
                'email_verified_at' => now(),
                'name' => $socialiteUser->name,
                'role_id' => 2,
            ]
        );
        return $user->createToken($user->first_name . ' ' . $user->email . ' - ' .date('l jS \of F Y h:i:s A'))->plainTextToken;
    }

    public function apiLogout(Request $request) {
        $user = $request->user();
        return $user->tokens()->delete();
    }
}

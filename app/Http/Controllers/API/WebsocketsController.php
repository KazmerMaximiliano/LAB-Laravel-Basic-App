<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Events\Hello;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsocketsController extends Controller
{
    public function test() {
        $user = User::find(auth()->id());

        broadcast(new Hello('Hello: ' . $user->name));

        return response()->json(['message' => 'Hello: ' . $user->name]);
    }
}

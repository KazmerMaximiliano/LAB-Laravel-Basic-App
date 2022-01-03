<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Events\Hello;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsocketsController extends Controller
{
    public function test() {
        broadcast(new Hello('Hello: ' . rand(10,100)));

        return response()->json(['message' => 'Hello: ' . rand(10,100)]);
    }
}

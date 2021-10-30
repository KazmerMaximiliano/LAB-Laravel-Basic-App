<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class Scope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $scope)
    {
        $user = User::find(auth()->id());
        $rol = Role::find($user->role_id);
        $permissions = explode(" ", $rol->permission);

        if (in_array($scope, $permissions)) {
            return $next($request);
        } else {
            return response()->json('forbidden', 403);
        }
    }
}

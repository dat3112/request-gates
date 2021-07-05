<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $allowsRoles = explode('|', $role);
        $userRole = Auth::user()->role->name;
        if (in_array($userRole, $allowsRoles)) {
            return $next($request);
        }
        return response()->json([
            'message' => config('constants.CHECKROLE.NOT_PERMISSION')
        ], 403);
    }
}

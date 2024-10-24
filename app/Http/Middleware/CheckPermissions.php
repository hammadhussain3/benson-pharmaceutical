<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            if (Auth::user()->hasPermission($permission)) {
                return $next($request);
            }
        }

        // Redirect or respond as needed when permission is not granted
        abort(403, 'Unauthorized action.');
        // return redirect()->route('users.unauthorized');
    }
}
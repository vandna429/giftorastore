<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Only allow the fixed admin email
        if (Auth::user()->email !== 'admin@example.com') {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}

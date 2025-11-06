<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin email
        if (auth()->check() && auth()->user()->email === 'admin@studentportal.com') {
            return $next($request);
        }

        // Redirect non-admin users to home with error message
        return redirect('/')->with('error', 'You do not have permission to access the admin area.');
    }
}
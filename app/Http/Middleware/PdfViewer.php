<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PdfViewer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 1 || $user->role == 2 || $user->role == 3) {
                return $next($request);
            }
        }
        return redirect('/login')->with('alert', 'This is an alert message.');
    }
}

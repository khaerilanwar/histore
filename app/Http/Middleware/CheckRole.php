<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('cashier*') && (Auth::user()->role !== 2)) {
            abort(403, 'Unauthorized');
        } elseif ($request->is('admin*') && (Auth::user()->role !== 1)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

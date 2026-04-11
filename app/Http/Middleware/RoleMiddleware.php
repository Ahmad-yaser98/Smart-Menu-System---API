<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'يرجى تسجيل الدخول أولاً.'
            ], 401);
        }

       
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== $role) {
            return response()->json([
                'message' => 'غير مصرح لك للقيام بهذه العملية.'
            ], 403);
        }

        return $next($request);
    }
}
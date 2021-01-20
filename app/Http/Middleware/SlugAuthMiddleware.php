<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class SlugAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->route('slug')) {
            abort(404);
        }
        
        if(!User::wherePublicSlug($request->route('slug'))->exists()) {
            abort(404);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\SaveClick;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Click
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $click = new SaveClick;
        $click->click = $request->path();
        $click->save();
        return $next($request);
    }
}

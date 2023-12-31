<?php

namespace App\Http\Middleware;

use App\Utils\Utils;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentAuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, Utils $utils): Response
    {
        if ($request->user()->role !== "Agent")
            return $utils->message("success", "Unauthorized Access", 422);

        return $next($request);
    }
}

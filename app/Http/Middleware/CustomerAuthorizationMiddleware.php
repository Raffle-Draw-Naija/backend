<?php

namespace App\Http\Middleware;

use App\Utils\Utils;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user()->role !== "Customer")
            return \response()->json(["msg" => "error", "data" => "Unauthorized Access"], 422);


        return $next($request);
    }
}

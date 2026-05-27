<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there's an active maintenance record in database
        $maintenance = \App\Models\Maintenance::where('status', 'active')->first();
        
        if ($maintenance) {
            return redirect("/maintenance");
        }
        
        return $next($request);
    }

}
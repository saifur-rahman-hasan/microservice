<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class IdentifyMicroServiceProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $serviceCode = $request->segment(2);
        $endpointCode = $request->segment(3);

        if( $serviceCode && $endpointCode ){
            return $next($request);
        }

        return response()->json([
            'message' => 'Sorry! Service cannot resolve because invalid service code or service endpoint detected.'
        ], 500);
    }
}

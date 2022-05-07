<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors {
    public function handle(Request $request, Closure $next) {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
        return $response;
    }
}

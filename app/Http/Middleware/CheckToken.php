<?php

namespace App\Http\Middleware;
use \App\User;
use Closure;

class CheckToken
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
            if(!isset(User::where('token', $request->bearerToken())->first()->id)){
                return response()->json([
                    'error' => '403', 'message' => 'invalid token'
                ], 403);
            }
            return $next($request);
    }
}
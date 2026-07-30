<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthMiddleware
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
        $username = $request->getUser();
        $password = $request->getPassword();
        $validUsername = 'auth';
        $validPassword = '12Pran@123456$';
        if($username !== $validUsername || $password !== $validPassword) {
            $headers = ['WWW-Authenticate' => 'Basic'];
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid authentication credentials'
            ], 401, $headers);
        }
        return $next($request);
    }
}
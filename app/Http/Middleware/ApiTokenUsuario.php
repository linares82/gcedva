<?php

namespace App\Http\Middleware;

use Closure;

class ApiTokenUsuario
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
        //dd($request->header);
        if ($request->header('Authorization')) {
            $usuario = User::where('api_token', $request->header('Authorization'))->first();
            if (!is_null($usuario)) {
                return $next($request);
            }
        }
        return response()->json([
            'message' => 'Token incorrecto.',
        ]);
    }
}

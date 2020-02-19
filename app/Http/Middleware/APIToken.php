<?php

namespace App\Http\Middleware;

use App\Cliente;

use Closure;

class APIToken
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
            //$usuario = User::where('api_token', $request->header('Authorization'))->first();
            $cliente = Cliente::where('api_token', $request->header('Authorization'))->first();
            if (!is_null($cliente)) {
                return $next($request);
            }
        }
        return response()->json([
            'message' => 'Token incorrecto.',
        ]);
    }
}

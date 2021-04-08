<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLockAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->isLocked) {
            return abort(403, 'locked');
            // return response(['message' => "Akun ini terkunci. untuk membuka silahkan masukan password terlebih dahulu"], 403);
        }
        return $next($request);
    }
}

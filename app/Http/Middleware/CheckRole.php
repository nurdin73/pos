<?php

namespace App\Http\Middleware;

use App\Models\RoleAccess;
use App\Models\SubMenu;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $menuName)
    {
        $menu = SubMenu::where('url', $menuName)->whereHas('roleAcceses', function($q) {
            $q->where('role_id', auth()->user()->role_id)->where('isGranted', 1);
        })->first();
        if(!$menu) {
            abort(403);
        }
        return $next($request);
    }
}

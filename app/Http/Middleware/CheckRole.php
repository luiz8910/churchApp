<?php

namespace App\Http\Middleware;

use App\Models\Person;
use App\Repositories\PersonRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  int $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!Auth::check())
        {
            return redirect('/');
        }

        $role_id = Auth::getUser()->person->role_id;

        if($role_id <> $role)
        {
            return redirect("/");
        }

        return $next($request);
    }
}

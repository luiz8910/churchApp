<?php

namespace App\Http\Middleware;

use App\Repositories\RoleRepository;
use Closure;

class CheckAdmin
{

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {

        $this->roleRepository = $roleRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!\Auth::check())
        {
            return redirect()->route('login.admin');
        }

        $admin = \Auth::user()->admin_id;

        if($admin != $role)
        {
            return redirect()->route('login.admin');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Person;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\VisitorRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  int $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $role2)
    {
        if(!Auth::check())
        {
            return redirect('/home');
        }

        //Id do cargo/role de visitante
        $visitors_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        $role_id = Auth::user()->person ? Auth::user()->person->role_id : $visitors_id;

        if($role_id <> $role && $role_id <> $role2)
        {
            return redirect("/home");
        }

        return $next($request);
    }
}

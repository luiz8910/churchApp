<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 30/05/2017
 * Time: 12:29
 */

namespace App\Traits;


use App\Models\Role;
use App\Repositories\RoleRepository;
use Auth;

trait ConfigTrait
{
    /**
     * @var RoleRepository
     */
    private $roleRepositoryTrait;

    /**
     * ConfigTrait constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepositoryTrait)
    {
        $this->roleRepositoryTrait = $roleRepositoryTrait;
    }

    public function getPusherKeyTrait()
    {
        $key = env("PUSHER_KEY");

        return json_encode($key);
    }

    public function getUserChurch()
    {
        return Auth::getUser()->church_id;
    }

    public function getLeaderRoleId()
    {
        return Role::where('name', 'Lider')->first()->id;
    }
}
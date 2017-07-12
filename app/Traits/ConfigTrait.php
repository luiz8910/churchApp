<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 30/05/2017
 * Time: 12:29
 */

namespace App\Traits;


use App\Models\Frequency;
use App\Models\Role;
use App\Repositories\FrequencyRepository;
use App\Repositories\RoleRepository;
use Auth;

trait ConfigTrait
{
    /**
     * @var RoleRepository
     */
    private $roleRepositoryTrait;
    /**
     * @var FrequencyRepository
     */
    private $frequencyRepositoryTrait;

    /**
     * ConfigTrait constructor.
     * @param RoleRepository $roleRepositoryTrait
     * @param FrequencyRepository $frequencyRepositoryTrait
     * @internal param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepositoryTrait, FrequencyRepository $frequencyRepositoryTrait)
    {
        $this->roleRepositoryTrait = $roleRepositoryTrait;
        $this->frequencyRepositoryTrait = $frequencyRepositoryTrait;
    }

    public function getPusherKeyTrait()
    {
        $key = env("PUSHER_KEY");

        return json_encode($key);
    }

    public function getUserChurch()
    {
        return Auth::user()->church_id;
    }

    public function getLeaderRoleId()
    {
        return Role::where('name', 'Lider')->first()->id;
    }

    public function daily()
    {
        return 'Diário';
    }

    public function weekly()
    {
        return 'Semanal';
    }

    public function monthly()
    {
        return 'Mensal';
    }

    /*
     * Retorna qual a qtde de replicação de um evento
     * No momento de sua criação*/
    public function numNextEvents()
    {
        return 5;
    }

    //Retorna o número de semanas que serão exibidas na agenda
    public function getDefaultWeeks()
    {
        return 6;
    }
}
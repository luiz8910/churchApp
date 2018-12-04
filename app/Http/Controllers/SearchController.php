<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\Person;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\GroupRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Traits\ConfigTrait;
use App\Traits\DateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Scout\Engines\AlgoliaEngine;

class SearchController extends Controller
{
    use ConfigTrait, DateRepository;


    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository,
                                GroupRepository $groupRepository)
    {

        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    public function findNewPeople($input)
    {
        $church_id = $this->getUserChurch();

        $people = DB::table('people')
                    ->where(
                        [
                            ['name', 'like', $input.'%'],
                            ['church_id', '=', $church_id],
                            ['deleted_at', '=', null],
                            'status' => 'active'
                        ]
                    )
                    ->get();


        if(count($people) > 0)
        {
            $arr = [];

            foreach ($people as $person)
            {
                $arr[] = $person->imgProfile;
                $arr[] = $person->name . " " . $person->lastName;
                $arr[] = $person->id;
            }

            return json_encode([
                'status' => true,
                'data' => $arr
            ]);
        }

        return json_encode(['status' => false]);
    }

    /**
     * @param $input
     * @param $status
     * @return string
     */
    public function searchPerson($input, $status, $approval = null)
    {
        $church_id = $this->getUserChurch();

        $symbol = $status == 'inactive' ? '<>' : '=';

        $fullName = explode(" ", $input);

        $table = $status == 'visitor' ? 'visitors' : 'people';

        $url = env('APP_URL');

        $route = str_replace($url, "", url()->previous());

        $tag = $route == 'teen' ? '<>' : '=';

        if(count($fullName) > 1)
        {

            if($table == 'visitors')
            {
                $people = DB::table($table)
                    ->where(
                        [
                            ['name', 'like', '%'.$fullName[0].'%'],
                            ['lastName', 'like', $fullName[1].'%'],
                            ['deleted_at', $symbol, null],
                            'status' => 'active'
                        ]
                    )
                    ->limit(5)
                    ->orderBy('name', 'desc')
                    ->get();
            }else{
                if($status == 'inactive')
                {
                    $people = DB::table($table)
                        ->where(
                            [
                                ['name', 'like', '%'.$fullName[0].'%'],
                                ['lastName', 'like', $fullName[1].'%'],
                                ['church_id', '=', $church_id],
                                ['deleted_at', $symbol, null],
                                'status' => 'active'
                            ]
                        )
                        ->limit(5)
                        ->orderBy('name', 'desc')
                        ->get();
                }else{
                    if($approval)
                    {
                        $people = DB::table($table)
                            ->where(
                                [
                                    ['name', 'like', '%'.$fullName[0].'%'],
                                    ['lastName', 'like', $fullName[1].'%'],
                                    ['church_id', '=', $church_id],
                                    ['deleted_at', $symbol, null],
                                    ['status', '<>', 'active']
                                ]
                            )
                            ->limit(5)
                            ->orderBy('name', 'desc')
                            ->get();
                    }
                    else{

                        $people = DB::table($table)
                            ->where(
                                [
                                    ['name', 'like', '%'.$fullName[0].'%'],
                                    ['lastName', 'like', $fullName[1].'%'],
                                    ['church_id', '=', $church_id],
                                    ['tag', $tag, 'adult'],
                                    ['deleted_at', $symbol, null],
                                    'status' => 'active'
                                ]
                            )
                            ->limit(5)
                            ->orderBy('name', 'desc')
                            ->get();
                    }

                }

            }

        }
        else{

            if($table == "visitors")
            {
                $people = DB::table($table)
                    ->where(
                        [
                            ['name', 'like', '%'.$input.'%'],
                            ['deleted_at', $symbol, null],
                            'status' => 'active'
                        ]
                    )
                    ->limit(5)
                    ->orderBy('name', 'desc')
                    ->get();
            }
            else{
                if($status == "inactive")
                {
                    $people = DB::table($table)
                        ->where(
                            [
                                ['name', 'like', '%'.$input.'%'],
                                ['church_id', '=', $church_id],
                                ['deleted_at', $symbol, null],
                                'status' => 'active'
                            ]
                        )
                        ->limit(5)
                        ->orderBy('name', 'desc')
                        ->get();
                }
                else{
                    if($approval)
                    {

                        $people = DB::table($table)
                            ->where(
                                [
                                    ['name', 'like', '%'.$fullName[0].'%'],
                                    ['church_id', '=', $church_id],
                                    ['deleted_at', $symbol, null],
                                    ['status', '<>', 'active']
                                ]
                            )
                            ->limit(5)
                            ->orderBy('name', 'desc')
                            ->get();

                    }
                    else{

                        $people = DB::table($table)
                            ->where(
                                [
                                    ['name', 'like', '%'.$input.'%'],
                                    ['church_id', '=', $church_id],
                                    ['tag', $tag, 'adult'],
                                    ['deleted_at', $symbol, null],
                                    'status' => 'active'
                                ]
                            )
                            ->limit(5)
                            ->orderBy('name', 'desc')
                            ->get();
                    }

                }

            }

        }



        if(count($people) > 0)
        {
            $arr = [];

            if($status == "inactive")
            {
                foreach ($people as $person)
                {
                    $arr[] = $person->imgProfile;
                    $arr[] = $person->name . " " . $person->lastName;
                    $arr[] = $person->id;
                }
            }
            elseif($status == "people" && !$approval)
            {
                foreach ($people as $person)
                {
                    $person->role = $this->roleRepository->find($person->role_id)->name;
                    $person->dateBirth = $this->formatDateView($person->dateBirth);
                    $person->cpf = $person->cpf ? $person->cpf : '';

                    $arr[] = $person->imgProfile;
                    $arr[] = $person->name . " " . $person->lastName;
                    $arr[] = $person->cpf;
                    $arr[] = $person->role;
                    $arr[] = $person->dateBirth;
                    $arr[] = $person->id;

                }
            }

            elseif($approval)
            {

                foreach ($people as $person)
                {

                    if($person->tag == 'adult')
                    {
                        $tag = 'person';
                    }
                    else{

                        $tag = 'teen';
                    }

                    $arr[] = $person->imgProfile;

                    $arr[] = $tag;

                    $arr[] = $person->id;

                    $arr[] = $person->name . " " . $person->lastName;

                    $arr[] = $person->email;

                    $arr[] = date_format(date_create($person->created_at), 'd/m/Y');

                    $arr[] = $person->status;


                }

            }
            else{

                foreach($people as $person)
                {
                    $person->dateBirth = $this->formatDateView($person->dateBirth);
                    $person->cpf = $person->cpf ? $person->cpf : '';

                    $arr[] = $person->imgProfile;
                    $arr[] = $person->name . " " . $person->lastName;
                    $arr[] = $person->cpf;
                    $arr[] = $person->dateBirth;
                    $arr[] = $person->id;
                }
            }


            return json_encode([
                'status' => true,
                'data' => $arr
            ]);
        }

        return json_encode(['status' => false]);
    }

    public function searchGroup($input)
    {
        $church_id = $this->getUserChurch();

        $fullName = explode(" ", $input);

        if(count($fullName) > 1)
        {
            $groups = DB::table('groups')
                ->where(
                    [
                        ['name', 'like', '%'.$fullName[0].'%'],
                        ['lastName', 'like', $fullName[1].'%'],
                        ['deleted_at', '=', null]
                    ]
                )
                ->limit(5)
                ->orderBy('name', 'desc')
                ->get();
        }
        else{

            $groups = DB::table('groups')
                ->where(
                    [
                        ['name', 'like', '%'.$input.'%'],
                        ['church_id', '=', $church_id],
                        ['deleted_at', '=', null]
                    ]
                )
                ->limit(5)
                ->orderBy('name', 'desc')
                ->get();
        }

        if(count($groups) > 0)
        {
            $arr = [];

            foreach($groups as $group)
            {
                $group->qtde = count(DB::table('group_person')->where([
                    'group_id' => $group->id
                ])->get());

                $arr[] = $group->imgProfile;
                $arr[] = $group->name;
                $arr[] = $this->formatDateView($group->sinceOf);
                $arr[] = $group->qtde;
                $arr[] = $group->id;
            }

            return json_encode([
                'status' => true,
                'data' => $arr
            ]);
        }

        return json_encode(['status' => false]);
    }

    function searchEvent($input)
    {
        $church_id = $this->getUserChurch();

        $fullName = explode(" ", $input);

        if(count($fullName) > 1)
        {
            $events = DB::table('events')
                ->where(
                    [
                        ['name', 'like', '%'.$fullName[0].'%'],
                        ['church_id', '=', $church_id],
                        ['deleted_at', '=', null]
                    ]
                )
                ->limit(5)
                ->orderBy('name', 'desc')
                ->get();
        }
        else{

            $events = DB::table('events')
                ->where(
                    [
                        ['name', 'like', '%'.$input.'%'],
                        ['church_id', '=', $church_id],
                        ['deleted_at', '=', null]
                    ]
                )
                ->limit(5)
                ->orderBy('name', 'desc')
                ->get();
        }

        if(count($events) > 0)
        {
            $arr = [];

            foreach($events as $event)
            {
                $event->createdBy = $this->userRepository->find($event->createdBy_id)->person;

                $event->group = $event->group_id ? $this->groupRepository->find($event->group_id)->name : 'Sem Grupo';

                $arr[] = $event->name;
                $arr[] = $event->frequency;
                $arr[] = $event->createdBy->name . " " . $event->createdBy->lastName;
                $arr[] = $event->group;
                $arr[] = $event->id;
            }

            return json_encode([
                'status' => true,
                'data' => $arr
            ]);
        }

        return json_encode(['status' => false]);
    }

    public function generalSearch($input, $table, $column = null)
    {
        /*
         * Exibe todos os campos da tabela $table
         * na ordem correta para uso em custom.js
         */
        $fields = DB::table('fields_search')
                    ->where([
                        'table' => $table
                    ])->select('field')->orderBy('order')->get();

        $select = [];

        foreach ($fields as $field)
        {
            //Armazenando os nomes de colunas da table $table
            $select[] = $field->field;
        }

        //Se alguma coluna for especificado na hora da request
        if($column)
        {
            $data = DB::table($table)
                ->where([
                    [$column, 'like', '%'.$input.'%'],
                ])->select($select)->get();
        }
        //Coluna padrão name
        else{
            $data = DB::table($table)
                ->where([
                    ['name', 'like', '%'.$input.'%'],
                ])->select($select)->get();
        }


        $i = 0;

        //Trabalha com cada resultado separadamente
        foreach ($data as $item)
        {
            /*
             * iteração com valor de $i menor que
             * a qtde de colunas da tabela
             */
            while ($i < count($select))
            {
                /*
                 * É necessário verificar se a coluna em questão é
                 * category_id, pois vamos tirar a id e colocar o nome
                 * da categoria para ser exibido no Html
                 */
                if($select[$i] == 'category_id')
                {
                    //Procura o nome da tabela pai
                    $parent = DB::table('parent_table')->where(['child' => $table])->first()->parent;

                    //Se houver uma tabela pai
                    if(count($parent) > 0)
                    {
                        //Troca de id para o nome da categoria
                        $item->category_id = DB::table($parent)->where(['id' => $item->category_id])->first()->name;

                        //armazena o valor
                        $arr[] = $item->category_id;
                    }
                }
                else{
                    /*
                     * Informa ao js a coluna para exibir,
                     * na ordem correta feita no select de fields_search
                     */
                    $arr[] = $item->$select[$i];
                }

                $i++;
            }

            $i = 0;


        }

        /*
         * data = Dados coletados
         * select = Nomes das colunas da tabela
         */
        return json_encode(['status' => true, 'data' => $arr, 'select' => $select]);
    }


    public function search($input, $origin = null)
    {
        $name = DB::table('people')
                    ->where([
                        ['name', 'like', '%'.$input.'%'],
                        'church_id' => $this->getUserChurch(),
                        'deleted_at' => null

                    ])->get();

        $lastName = DB::table('people')
            ->where([
                ['lastName', 'like', '%'.$input.'%'],
                'church_id' => $this->getUserChurch(),
                'deleted_at' => null

            ])->get();

        $email = DB::table('people')
            ->where([
                ['email', 'like', '%'.$input.'%'],
                'church_id' => $this->getUserChurch(),
                'deleted_at' => null

            ])->get();

        $cpf = DB::table('people')
            ->where([
                ['cpf', 'like', '%'.$input.'%'],
                'church_id' => $this->getUserChurch(),
                'deleted_at' => null

            ])->get();

        $groups = DB::table('groups')
            ->where([
                ['name', 'like', '%'.$input.'%'],
                'church_id' => $this->getUserChurch(),
                'deleted_at' => null

            ])->get();

        $events = DB::table('events')
            ->where([
                ['name', 'like', '%'.$input.'%'],
                'church_id' => $this->getUserChurch(),
                'deleted_at' => null

            ])->get();

        $visitors = DB::table('visitors')
            ->where([
                ['name', 'like', '%'.$input.'%'],
                'deleted_at' => null

            ])->get();

        $qtde = 0;

        if(count($name) > 0)
        {
            $qtde++;

            foreach ($name as $item)
            {
                $item->model = 'person';
            }
        }

        if(count($lastName) > 0)
        {
            $qtde++;

            foreach ($lastName as $item)
            {
                $item->model = 'person';
            }
        }


        if(count($email) > 0)
        {
            $qtde++;

            foreach ($email as $item)
            {
                $item->model = 'person';
            }
        }


        if(count($groups) > 0)
        {
            $qtde++;

            foreach ($groups as $group)
            {
                $group->model = 'group';
            }
        }


        if(count($events) > 0)
        {
            $qtde++;

            foreach($events as $event)
            {
                $event->model = 'events';
            }
        }


        if(count($visitors) > 0)
        {
            $qtde++;

            foreach ($visitors as $visitor)
            {
                $visitor->model = 'visitors';
            }
        }


        if(count($cpf) > 0)
        {
            $qtde++;

            foreach($cpf as $item)
            {
                $item->model = 'person';
            }
        }


        $merge = $name->merge($lastName)
                    ->merge($email)
                    ->merge($groups)
                    ->merge($events)
                    ->merge($visitors)
                    ->merge($cpf);


        $status = $qtde == 0 ? false : true;

        return json_encode([
            'status' => $status,
            'data' => $merge->unique('id', 'model')
        ]);





        //dd($merge->unique('id', 'model'));


    }
}

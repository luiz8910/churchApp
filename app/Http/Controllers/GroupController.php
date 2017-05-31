<?php

namespace App\Http\Controllers;


use App\Mail\resetPassword;
use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use App\Repositories\UserRepository;
use App\Services\GroupServices;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps, UserLoginRepository,
        NotifyRepository, PeopleTrait, ConfigTrait;
    /**
     * @var GroupRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var GroupServices
     */
    private $groupServices;

    /**
     * GroupController constructor.
     * @param GroupRepository $repository
     * @param StateRepository $stateRepository
     * @param RoleRepository $roleRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(GroupRepository $repository, StateRepository $stateRepository,
                                RoleRepository $roleRepository, PersonRepository $personRepository,
                                UserRepository $userRepository, GroupServices $groupServices)
    {

        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
        $this->groupServices = $groupServices;
    }
    /**
     * Exibe todos os grupos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $church_id = $this->getUserChurch();
        //$groups = Group::withTrashed()->get();

        $groups = Group::where('church_id', $church_id)->paginate(10);

        foreach ($groups as $group)
        {
            $group->sinceOf = $this->formatDateView($group->sinceOf);
            $countMembers[] = count($group->people->all());
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        return view('groups.index', compact('groups', 'countPerson', 'countMembers', 'countGroups', 'notify', 'qtde'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $notify = $this->notify();

        $qtde = count($notify);

        return view('groups.create', compact('countPerson', 'countGroups', 'state', 'roles', 'notify', 'qtde'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('img');

        $data = $request->except(['img']);

        $data['sinceOf'] = $this->formatDateBD($data['sinceOf']);

        $data['owner_id'] = \Auth::getUser()->id;

        $data['church_id'] = $this->getUserChurch();

        $id = $this->repository->create($data)->id;

        $this->imgProfile($file, $id, $data['name']);

        return redirect()->route('group.index');
    }

    public function imgProfile($file, $id, $name)
    {
        $imgName = 'uploads/group/' . $id . '-' . $name . '.' .$file->getClientOriginalExtension();

        $file->move('uploads/group', $imgName);

        DB::table('groups')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        //$request->session()->flash('updateUser', 'Alterações realizadas com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = $this->repository->find($id);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        //endereço formatado para api do google maps
        $location = $this->formatGoogleMaps($group);

        $people = $group->people->all();

        //dd($people[0]->user->email);

        return view('groups.show', compact('group', 'countPerson', 'countGroups', 'location', 'people'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->repository->find($id);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        //$events = $this->groupServices->listGroupEvents($group);

        $events = $this->groupServices->listGroupEvents($group);

        //Endereço do grupo formatado para api do google maps
        $location = $this->formatGoogleMaps($group);

        //Listagem de todos os membros do grupo
        $members = $group->people->all();

        $pag = $this->paginate($group->people->all())->setPath('');

        $address = [];

        $arr = [];

        foreach ($members as $item)
        {
            //Separando a id de cada membro do grupo num array
            $arr[] = $item->id;

            //Separando o endereço formatado para a api do google maps
            //de cada membro do grupo num array
            $address[] = $this->formatGoogleMaps($item);
        }

        $quantitySingleMother = '';
        $quantitySingleFather = '';
        $quantitySingleWomen = '';
        $quantitySingleMen = '';
        $quantityMarriedWomenNoKids = '';
        $quantityMarriedMenNoKids = '';

        //Quantidade de todas as mulheres solteiras com filhos que pertencem ao grupo
        $quantitySingleMother = $this->quantitySingleMother($arr);

        //Quantidade de todos os homens solteiros com filhos que pertencem ao grupo
        $quantitySingleFather = $this->quantitySingleMen($arr);

        //Quantidade de todas as mulheres solteiras e adultas
        $quantitySingleWomen = $this->quantitySingleWomen($arr);

        //Quantidade de todos os homens solteiros e adultos
        $quantitySingleMen = $this->quantitySingleMen($arr);

        //Quantidade de mulheres casadas sem filhos
        $quantityMarriedWomenNoKids = $this->quantityMarriedWomenNoKids($arr);

        //Quantidade de homens casados sem filhos
        $quantityMarriedMenNoKids = $this->quantityMarriedMenNoKids($arr);

        //Quantidade de homens com parceira fora da igreja
        $quantityMarriedWomenOutsideChurch = $this->quantityMarriedWomenOutsideChurch($arr);

        //Quantidade de mulheres com parceiro fora da igreja
        $quantityMarriedMenOutsideChurch = $this->quantityMarriedMenOutsideChurch($arr);

        //Listagem de todas as pessoas que não pertencem ao grupo
        $people = $this->personRepository->findWhereNotIn('id', $arr);

        $roles = $this->roleRepository->all();

        $state = $this->stateRepository->all();

        $group->sinceOf = $this->formatDateView($group->sinceOf);

        $user = $this->userRepository->find(\Auth::getUser()->id);

        //Eventos que o usuário está inscrito
        $event_user[] = $user->person->events->all();//dd($event_user);

        $notify = $this->notify();

        $qtde = count($notify);

        //dd($event_user[0][1]["id"]);

        //dd(isset($event_user[0][1]));

        //dd(count($event_user[0]));

        return view('groups.edit', compact('group', 'countPerson', 'countGroups', 'events', 'address', 'location',
            'people', 'roles', 'state', 'members', 'quantitySingleMother', 'quantitySingleFather', 'quantitySingleWomen',
            'quantitySingleMen', 'quantityMarriedWomenNoKids', 'quantityMarriedMenNoKids',
            'quantityMarriedWomenOutsideChurch', 'quantityMarriedMenOutsideChurch', 'event_user', 'notify', 'qtde', 'pag'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('img');

        $data = $request->except(['img']);

        $data['sinceOf'] = $this->formatDateBD($data['sinceOf']);

        $data['church_id'] = $this->getUserChurch();

        $this->repository->update($data, $id);

        if ($file){
            $this->imgProfile($file, $id, $data['name']);
        }

        return redirect()->route('group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return json_encode(true);
    }

    public function addMembers(Request $request, $group)
    {
        $arr = [];
        $i = 0;

        $gr = $this->repository->find($group);

        foreach ($request->all() as $item) {
            $arr[] = $item;

            if($i > 0){
                $gr->people()->attach($arr[$i]);
            }

            $i++;
        }


        return redirect()->route('group.edit', ['id' => $group]);
    }

    public function deleteMember($group, $member)
    {
        $gr = $this->repository->find($group);

        $gr->people()->detach($member);

        \Session::flash('group.deleteMember', 'Usuário excluido com sucesso');

        return json_encode(true);

        //return redirect()->route('group.edit', ['id' => $group]);
    }

    public function newMemberToGroup(Request $request, $group)
    {
        $data = $request->except('email');

        $data["dateBirth"] = $this->formatDateBD($data["dateBirth"]);

        $data["role_id"] = $this->roleRepository->findByField('name', 'Membro')->first()->id;

        $data["imgProfile"] = "uploads/profile/noimage.png";

        $user = $this->personRepository->create($data);

        $user->groups()->attach($group);

        $email = $request->only('email');

        $email = $email["email"];

        $church = $request->user()->church_id;

        $this->updateTag($this->tag($data['dateBirth']), $user->id, 'people');

        $password = $this->randomPassword();

        $this->createUserLogin($user->id, $password, $email, $church);

        $url = env('APP_URL');

        $today = date("d/m/Y");

        $time = date("H:i");

        $u = User::find($user->user->id);

        Mail::to($u)
            ->send(new resetPassword(
                $u, $url, $today, $time, $password
            ));

        \Session::flash('group.deleteMember', 'Sucesso!, um email com a senha foi enviado para ' . $email);

        return redirect()->route('group.edit', ['id' => $group]);
    }

    /**
     * Quantidade de todas as mulheres solteiras com filhos que pertencem ao grupo
     * @param $members
     * @return int
     */
    public function quantitySingleMother($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && $person->hasKids && $person->maritalStatus == 'Solteiro')
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * @param $members
     * @return int
     */
    public function quantitySingleWomen($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && !$person->hasKids &&
                $person->maritalStatus == 'Solteiro' && $person->tag == 'adult')
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * @param $members
     * @return int
     */
    public function quantitySingleMen($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && !$person->hasKids &&
                $person->maritalStatus == 'Solteiro' && $person->tag == 'adult')
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * @param $members
     * @return int
     */
    public function quantitySingleFather($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && $person->hasKids && $person->maritalStatus == 'Solteiro')
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedWomenNoKids($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && !$person->hasKids && $person->maritalStatus == 'Casado')
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedMenNoKids($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && !$person->hasKids && $person->maritalStatus == 'Casado')
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedMenOutsideChurch($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && $person->maritalStatus == 'Casado' && $person->partner == 0)
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedWomenOutsideChurch($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && $person->maritalStatus == 'Casado' && $person->partner == 0)
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * Create a length aware custom paginator instance.
     *
     * @param  Collection  $items
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate($items, $perPage = 10)
    {
        //Get current page form url e.g. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $currentPageItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }

    public function destroyManyUsers(Request $request)
    {
        $i = 0;

        $data = $request->all();

        while($i < count($data['input']))
        {
            $this->repository->delete($data['input'][$i]);
            $i++;
        }

        \Session::flash('member.deleted', 'Os usuários selecionados foram excluidos');

        return redirect()->route('group.index');
    }


    public function getListGroups()
    {
        $groups = $this->repository->all();

        $header[] = "Nome";
        $header[] = "Início";
        $header[] = "Quantidade";

        $i = 0;

        $text = "";

        while($i < count($groups))
        {
            $groups[$i]->sinceOf = $this->formatDateView($groups[$i]->sinceOf);

            $groups[$i]->qtde = count($groups[$i]->people->all());

            $x = $i == (count($groups) - 1) ? "" : ",";

            $text .= '["'.$groups[$i]->name.'","'.''.$groups[$i]->sinceOf.''.'","'.''.$groups[$i]->qtde.'"'.']'.$x.'';

            $i++;
        }

        $json = '{
              "content": [
                {
                  "table": {
                    "headerRows": 1,
                    "widths": [ "*", "auto", 100 ],
            
                    "body":[
                      ["'.$header[0].'", "'.$header[1].'", "'.$header[2].'"],
                      '.$text.'
                    ]
                  }
                }
              ]
            }';

        if (env('APP_ENV') == "local")
        {
            File::put(public_path('js/print.json'), $json);
        }
        else{
            File::put(getcwd() . '/js/print.json', $json);
        }
    }

    public function excel($format)
    {
        $data = $this->repository->all();

        $info = [];

        for($i = 0; $i < count($data); $i++)
        {
            $info[$i]["Nome"] = $data[$i]->name;

            $info[$i]["Desde"] = $this->formatDateView($data[$i]->sinceOf);

            $info[$i]["Quantidade"] = count($data[$i]->people);
        }


        //dd($info);

        Excel::create('Grupos', function($excel) use ($info) {

            // Set the title
            //$excel->setTitle('Our new awesome title');

            // Call them separately
            //$excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Grupos', function ($sheet) use ($info){
                $sheet->fromArray($info);
            });

        })->export($format);

        return redirect()->route('group.index');
    }


    public function addUserToGroup($personId, $group)
    {
        $registered = DB::table('group_person')
            ->where(
                [
                    'group_id' => $group,
                    'person_id' => $personId
                ])
            ->get();

        if(count($registered) > 0){
            return json_encode(['status' => false]);
        }

        $group = $this->repository->find($group);

        $group->people()->attach($personId);

        return json_encode(['status' => true]);
    }
}

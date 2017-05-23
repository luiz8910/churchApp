<?php

namespace App\Http\Controllers;

use App\Events\AgendaEvent;
use App\Events\PersonEvent;
use App\Http\Requests\PersonCreateRequest;
use App\Models\Event;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EventNotification;
use App\Notifications\Notifications;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\EmailTrait;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use App\Repositories\UserRepository;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Notification;
use File;

class PersonController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps, UserLoginRepository, NotifyRepository, EmailTrait, PeopleTrait;
    /**
     * @var PersonRepository
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
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PersonRepository $repository, StateRepository $stateRepository, RoleRepository $roleRepository,
                                UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adults = DB::table("people")
            ->where([
                'tag' => 'adult',
                'deleted_at' => null,
            ])->paginate(5);


        foreach ($adults as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);

        return view('people.index', compact('adults', 'countPerson', 'countGroups', 'notify', 'qtde'));
    }

    public function teenagers()
    {
        $teen = DB::table("people")
            ->where([
                ['tag', '<>', 'adult'],
                'deleted_at' => null,
            ])->paginate(5);

        foreach ($teen as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);

        return view('people.teenagers', compact('teen', 'countPerson', 'countGroups', 'notify', 'qtde'));
    }


    public function inactive()
    {
        $inactive = Person::onlyTrashed()->get();

        foreach ($inactive as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);

        return view('people.inactive', compact('inactive', 'countPerson', 'countGroups', 'notify', 'qtde'));
    }

    public function turnActive($id)
    {
        DB::table('people')->
        where('id', $id)->
        update(['deleted_at' => null]);

        return redirect()->route('person.inactive');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        $roles = $this->roleRepository->findWhereNotIn('id', [$visitor_id]);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $church_id = Auth::getUser()->church_id;

        $adults = $this->repository->findWhere(['tag' => 'adult', 'church_id' => $church_id]);

        $notify = $this->notify();

        $qtde = count($notify);

        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id
                ]
            )
            ->get();

        return view('people.create', compact('state', 'roles', 'countPerson', 'countGroups',
            'adults', 'notify', 'qtde', 'fathers', 'mothers'));
    }

    public function createTeen()
    {
        $state = $this->stateRepository->all();

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        $member_id = $this->roleRepository->findByField('name', 'Membro')->first()->id;

        $roles = $this->roleRepository->findWhereIn('id', [$member_id, $visitor_id]);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $church_id = Auth::getUser()->church_id;

        $notify = $this->notify();

        $qtde = count($notify);

        $adults = $this->repository->findWhere(['tag' => 'adult', 'church_id' => $church_id]);

        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id
                ]
            )
            ->get();

        return view('people.create-teen', compact('state', 'roles', 'countPerson', 'countGroups',
            'adults', 'notify', 'qtde', 'fathers', 'mothers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonCreateRequest $request)
    {
        $file = $request->file('img');//dd($request->all());

        $email = $request->only(['email']);

        $password = $request->only(['password']);

        $confirmPass = $request->only(['confirm-password']);

        $password = implode('=>', $password);

        $confirmPass = implode('=>', $confirmPass);

        if(!$password){
            \Session::flash("email.exists", "Escolha uma senha");
            return redirect()->route("person.create");
        }
        elseif($password != $confirmPass){
            \Session::flash("email.exists", "As senhas não combinam");
            $request->flashExcept('password');

            return redirect()->route("person.create")->withInput();
        }

        $email = $email["email"];

        $user = User::select('id')->where('email', $email)->first() or null;

        if($user)
        {
            \Session::flash("email.exists", "Existe uma conta associada para o email informado (" .$email. ")");

            $request->flashExcept('password');


            return redirect()->route("person.create")->withInput();
        }

        $data = $request->except(['img', 'email', 'password', 'confirm-password']);

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $children = $request->get('group-a');

        if($data['father_id_input'] || $data['mother_id_input'])
        {
            $data['father_id'] = $data['father_id_input'] or null;
            $data['mother_id'] = $data['mother_id_input'] or null;
        }

        $id = $this->repository->create($data)->id;

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;
        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'people');
        }

        $church_id = $request->user()->id;

        if ($this->repository->isAdult($data['dateBirth'])) {
            $this->createUserLogin($id, $password, $email, $church_id);

            if ($children) {

                DB::table('people')
                    ->where('id', $id)
                    ->update(['hasKids' => 1]);

                $this->children($children, $id, $data['gender'], $data["role_id"]);
            }

        }

        $this->updateTag($this->tag($data['dateBirth']), $id, 'people');

        if ($file) {
            $this->imgProfile($file, $id, $data['name'], 'people');
        }


        return redirect()->route('person.index');
    }


    public function imgEditProfile(Request $request, $id)
    {
        $name = $this->repository->find($id)->name;

        $file = $request->file('img');

        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('people')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        return redirect()->back();
    }




    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $person->dateBirth = $this->formatDateView($person->dateBirth);

        $location = $this->formatGoogleMaps($person);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $gender = $person->gender == 'M' ? 'F' : 'M';

        $church_id = Auth::getUser()->church_id;

        $adults = $this->repository->findWhere(['tag' => 'adult', 'gender' => $gender, 'church_id' => $church_id]);

        $notify = $this->notify();

        $qtde = count($notify);

        $children = null;

        if($person->hasKids == 1)
        {
            if ($person->gender == "M")
            {
                $children = $this->repository->findByField('father_id', $id);

                foreach ($children as $child)
                {
                    $child->dateBirth = $this->formatDateView($child->dateBirth);
                }
            }
            else{
                $children = $this->repository->findByField('mother_id', $id);

                foreach ($children as $child)
                {
                    $child->dateBirth = $this->formatDateView($child->dateBirth);
                }
            }
        }


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id
                ]
            )
            ->get();

        return view('people.edit', compact('person', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'adults', 'notify', 'qtde', 'fathers', 'mothers', 'children'));
    }


    public function editTeen($id)
    {
        $person = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $person->dateBirth = $this->formatDateView($person->dateBirth);

        $location = $this->formatGoogleMaps($person);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $church_id = Auth::getUser()->church_id;

        $notify = $this->notify();

        $qtde = count($notify) or 0;


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id
                ]
            )
            ->get();

        return view('people.edit-teen', compact('person', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'notify', 'qtde', 'fathers', 'mothers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['email']);

        $email = $request->only('email');

        //Formatação correta do email
        $email = $email["email"];

        //Formatação correta da data
        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        if($data['father_id_input'] || $data['mother_id_input'])
        {
            $data['father_id'] = $data['father_id_input'] or null;
            $data['mother_id'] = $data['mother_id_input'] or null;
        }

        if(!isset($data['maritalStatus']))
        {
            $data['maritalStatus'] = 'Solteiro';
        }

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;

            $status = $this->repository->find($id);

            if($status->maritalStatus == "Casado")
            {
                $this->updateMaritalSingleStatus($status->partner, $data["maritalStatus"], 'people');
            }

        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'people');
        }

        $user = $this->userRepository->findByField('person_id', $id)->first();

        if($email)
        {
            if($this->emailTestEditTrait($email, $user->id)){
                $this->updateEmail($email, $user->id);
            }
            else{
                \Session::flash("email.exists", "Existe uma conta associada para o email informado " . "(".$email.")");
                return redirect()->route("person.edit", ['person' => $id]);
            }
        }


        $this->repository->update($data, $id);

        return redirect()->route('person.index');
    }

    public function updateEmail($email, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['email' => $email]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = $this->repository->find($id);

        $user = $person->user->id;

        $this->userRepository->delete($user);

        $person->delete();

        return json_encode(true);
    }

    /*public function notify()
    {
        $user[] = User::findOrFail(1);

        $user[] = User::findOrFail(11);

        //$user->notify(new Notifications('123'));

        $person = $this->repository->find(1);

        //dd($person);

        $event = Event::findOrFail(1);

        //event(new AgendaEvent($event));

        //event(new PersonEvent($person));

        //event(new PersonEvent("teste"));

        foreach ($user as $item) {
            \Notification::send($item, new Notifications('novo Evento'));
        }


    }*/


    public function email()
    {
        $person = Person::find(1);
        Mail::to(User::find(1))->send(new teste($person));
    }


    public function getList($tag)
    {
        $people = "";

        $church_id = Auth::getUser()->church_id;

        if ($tag == "person") {
            $people = $this->repository->findWhere([
                ['tag' => 'adult'],
                ['church_id' => $church_id]
            ]);
        } elseif ($tag == "teen") {
            $people = $this->repository->findWhere([
                ['tag', '<>', 'adult'],
                ['church_id' => $church_id]
            ]);
        }

        $header[] = "Nome";
        $header[] = "CPF";
        $header[] = "Cargo";
        $header[] = "Data de Nasc.";

        $i = 0;

        $text = "";

        while ($i < count($people)) {
            $people[$i]->dateBirth = $this->formatDateView($people[$i]->dateBirth);

            $people[$i]->role_id = $people[$i]->role->name;

            $x = $i == (count($people) - 1) ? "" : ",";

            $text .= '["' . $people[$i]->name . ' ' . $people[$i]->lastName . '","' . '' . $people[$i]->cpf . '' . '","' . '' . $people[$i]->role_id . '' . '","' . '' . $people[$i]->dateBirth . '"' . ']' . $x . '';

            $i++;
        }


        $json = '{
              "content": [
                {
                  "table": {
                    "headerRows": 1,
                    "widths": [ "*", "auto", 100, "*" ],
            
                    "body":[
                      ["' . $header[0] . '", "' . $header[1] . '", "' . $header[2] . '", "' . $header[3] . '"],
                      ' . $text . '
                    ]
                  }
                }
              ]
            }';

        if (env('APP_ENV') == "local") {
            File::put(public_path('js/print.json'), $json);
        } else {
            File::put(getcwd() . '/js/print.json', $json);
        }
    }

    public function getListPeople()
    {
        return $this->getList("person");
    }

    public function getListTeen()
    {
        return $this->getList("teen");
    }

    public function personExcel($format)
    {
        return $this->excel($format, "person");
    }

    public function teenExcel($format)
    {
        return $this->excel($format, "teen");
    }

    public function visitorsExcel($format)
    {
        return $this->excel($format, 'visitors');
    }

    public function excel($format, $tag)
    {
        $data = "";

        if ($tag == "person") {
            $data = $this->repository->findByField('tag', 'adult');
        } elseif ($tag == "teen") {
            $data = $this->repository->findWhere([
                ['tag', '<>', 'adult']
            ]);
        } elseif ($tag == "visitors") {
            $role = $this->roleRepository->findByField('name', 'Visitante')->first();

            $data = $this->repository->findByField('role_id', $role->id);
        }

        $info = [];

        for ($i = 0; $i < count($data); $i++) {
            $info[$i]["Nome"] = $data[$i]->name;
            $info[$i]["CPF"] = $data[$i]->cpf;
            $info[$i]["Cargo"] = $data[$i]->role->name;
            $info[$i]["Data de Nasc."] = $this->formatDateView($data[$i]->dateBirth);
        }

        Excel::create("Pessoas", function ($excel) use ($info){

            $excel->sheet("Pessoas", function ($sheet) use ($info){
                $sheet->fromArray($info);
            });
        })->export($format);
    }

    public function storeVisitors(PersonCreateRequest $request)
    {
        return redirect()->route('person.visitors');
    }

    public function automaticCep($id)
    {
        $cep = $this->repository->find($id)->zipCode;

        return json_encode(['cep' => $cep]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonCreateRequest;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\VisitorRepository;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    use DateRepository, CountRepository, NotifyRepository, PeopleTrait, UserLoginRepository, FormatGoogleMaps;
    /**
     * @var VisitorRepository
     */
    private $repository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * VisitorController constructor.
     * @param VisitorRepository $repository
     */
    public function __construct(VisitorRepository $repository, RoleRepository $roleRepository, StateRepository $stateRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = $this->repository->paginate(5);

        foreach ($visitors as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);

        return view('people.visitors', compact('visitors', 'countPerson', 'countGroups', 'notify', 'qtde'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $adults = $this->repository->findWhere(['tag' => 'adult']);

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        return view('people.create-visitors', compact('state', 'countPerson', 'countGroups', 'adults', 'notify', 'qtde'));
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

        $data = $request->except(['img', '_token']);

        unset($data["role_id"]);

        $data['dateBirth'] = $data['dateBirth'] ? $this->formatDateBD($data['dateBirth']) : null;

        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $data['created_at'] = Carbon::now();

        $data['updated_at'] = Carbon::now();

        $id = DB::table('visitors')->insertGetId($data);

        $this->updateTag($this->tag($data['dateBirth']), $id, 'visitors');

        if ($file) {
            $this->imgProfile($file, $id, $data['name'], 'visitors');
        }

        $church = $request->user()->church_id;

        $visitor = $this->repository->find($id);

        $visitor->churches()->attach($church);

        $user = $this->createUserLogin(null, null, $data['email'], $church);

        $visitor->users()->attach($user);

        return redirect()->route('visitors.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->findWhereNotIn('id', [3]);

        $visitor->dateBirth = $this->formatDateView($visitor->dateBirth);

        $location = $this->formatGoogleMaps($visitor);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $gender = $visitor->gender == 'M' ? 'F' : 'M';

        $adults = $this->repository->findWhere(['tag' => 'adult', 'gender' => $gender]);

        $notify = $this->notify();

        $qtde = count($notify);

        return view('people.edit-visitors', compact('visitor', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'adults', 'notify', 'qtde'));
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
        $data = $request->all();

        $oldEmail = $this->repository->find($id)->first()->email;

        //Formatação correta da data
        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;
        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'visitors');
        }



        $user = $this->repository->findByField('email', $data["email"])->first() or null;


        if($user && ($user->id != $id))
        {
            \Session::flash("email.exists", "Existe uma conta associada para o email informado (" .$data["email"]. ")");

            $request->flashExcept('password');

            return redirect()->back()->withInput();
        }

        $this->repository->update($data, $id);

        DB::table("visitors")
            ->where('email', $oldEmail)
            ->update(['email' => $data["email"]]);

        DB::table('users')
            ->where('email', $oldEmail)
            ->update(['email' => $data["email"]]);

        return redirect()->route('visitors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitor = $this->repository->find($id);

        $visitor->churches()->detach();

        $visitor->users()->detach();

        $this->repository->delete($id);

        return redirect()->route('visitors.index');
    }

    public function login()
    {
        return view('auth.visitor');
    }

    public function imgEditProfile(Request $request, $id)
    {
        $name = $this->repository->find($id)->name;

        $file = $request->file('img');

        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('visitors')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        return redirect()->back();
    }

    public function getList()
    {
        $header[] = "Nome";
        $header[] = "CPF";
        $header[] = "Cargo";
        $header[] = "Data de Nasc.";

        $i = 0;

        $text = "";

        $church_id = Auth::getUser()->church_id;

        $visitors = $this->repository->findByField('church_id', $church_id);

        while ($i < count($visitors)) {
            $visitors[$i]->dateBirth = $this->formatDateView($visitors[$i]->dateBirth);

            $visitors[$i]->role_id = "Visitante";

            $x = $i == (count($visitors) - 1) ? "" : ",";

            $text .= '["' . $visitors[$i]->name . ' ' . $visitors[$i]->lastName . '","' . '' . $visitors[$i]->cpf . '' . '","' . '' . $visitors[$i]->role_id . '' . '","' . '' . $visitors[$i]->dateBirth . '"' . ']' . $x . '';

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

    public function checkCPF($cpf)
    {
        return $this->traitCheckCPF($cpf)->first();
    }
}
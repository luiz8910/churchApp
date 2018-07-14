<?phpnamespace App\Http\Controllers;use App\Models\Church;use App\Models\CreditCard;use App\Models\Responsible;use App\Models\Role;use App\Repositories\ChurchRepository;use App\Repositories\CreditCardRepository;use App\Repositories\PersonRepository;use App\Repositories\ResponsibleRepository;use App\Repositories\RoleRepository;use App\Repositories\StateRepository;use App\Services\ChurchServices;use App\Services\PagSeguroServices;use App\Traits\ConfigTrait;use App\Traits\DateRepository;use App\Traits\EmailTrait;use App\Traits\PeopleTrait;use App\Traits\UserLoginRepository;use Illuminate\Http\Request;use App\Services\PaymentServices;use Illuminate\Support\Facades\DB;class ChurchController extends Controller{    use PeopleTrait, DateRepository, UserLoginRepository, EmailTrait, ConfigTrait;    /**     * @var ChurchRepository     */    private $repository;    /**     * @var ResponsibleRepository     */    private $responsibleRepository;    private $paymentServices;    /**     * @var StateRepository     */    private $stateRepository;    /**     * @var RoleRepository     */    private $roleRepository;    /**     * @var PersonRepository     */    private $personRepository;    /**     * @var ChurchServices     */    private $churchServices;    /**     * @var CreditCardRepository     */    private $creditCardRepository;    public function __construct(ChurchRepository $repository, ResponsibleRepository $responsibleRepository,                                PaymentServices $paymentServices, StateRepository $stateRepository,                                RoleRepository $roleRepository, PersonRepository $personRepository,                                ChurchServices $churchServices, CreditCardRepository $creditCardRepository)    {        $this->repository = $repository;        $this->responsibleRepository = $responsibleRepository;        $this->paymentServices = $paymentServices;        $this->stateRepository = $stateRepository;        $this->roleRepository = $roleRepository;        $this->personRepository = $personRepository;        $this->churchServices = $churchServices;        $this->creditCardRepository = $creditCardRepository;    }    public function index()    {        $churches = Church::where('status', 'active')->paginate(5);        foreach ($churches as $church) {            $church->sinceOf = date_format($church->created_at, 'd/m/Y');        }        $state = $this->stateRepository->all();        return view('site.churches', compact('churches', 'state'));    }    public function getChurchesApi()    {        $churches = $this->repository->all();        return json_encode($churches);    }    public function newResponsible(Request $request, $plan_id)    {        $email = $request->get('email');        $name = $request->get('name');        $data = $request->except(['name, email']);        $role_id = Role::where(['name' => 'Administrador'])->first()->id;        $resp['email'] = $email;        $fullName = $this->surname($name);        $resp["name"] = ucfirst($fullName[0]);        if(isset($fullName[1]))        {            $resp["lastName"] = ucwords($fullName[1]);        }        $resp['role_id'] = $role_id;        if(count($this->responsibleRepository->findByField('email', $email)) == 0)        {            $responsible = $this->responsibleRepository->create($resp);            if($responsible)            {                $data['owner_id'] = $responsible->id;                $credit = $this->paymentServices->newCreditCard($data);                $church['name'] = 'Nova Igreja';                $church['email'] = $email;                $church['responsible_id'] = $responsible->id;                $church['tel'] = '999999';                $church['cnpj'] = '999999';                $church['plan_id'] = $plan_id;                if($credit)                {                    $church = $this->repository->create($church);                    if($church)                    {                        return redirect()->route('post.confirmation', ['id' => $responsible->id]);                    }                }            }        }        $request->session()->flash('error.msg', 'Um erro ocorreu');        return redirect()->back();    }    public function verifyCreditCard($number)    {        if($this->paymentServices->cardExists($number))        {            return json_encode(['status' => true, 'cardExists' => true]);        }        return json_encode(['status' => true, 'cardExists' => false]);    }    public function postConfirmation($id)    {        $responsible = $this->responsibleRepository->find($id);        $state = $this->stateRepository->all();        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;        $roles = $this->roleRepository->findWhereNotIn('id', [$visitor_id]);        $role_id = $responsible->role_id;        $email = $responsible->email;        $name = $responsible->name;        $lastName = $responsible->lastName;        $church = $this->repository->findByField('responsible_id', $id)->first();        $route = 'confirmation';        return view('churches.post-confirmation', compact('responsible', 'state', 'roles', 'role_id', 'email',                        'name', 'lastName', 'church', 'route'));    }    public function storeResponsible(Request $request)    {        try{            $resp = $request->only([                'name', 'lastName', 'email', 'cel', 'dateBirth', 'cpf', 'gender', 'maritalStatus',                'zipCode', 'street', 'neighborhood', 'city', 'state', 'number'            ]);            $church_array = $request->only([                'church_name', 'church_alias', 'tel', 'cnpj', 'zipCode-2', 'street-2', 'neighborhood-2', 'city-2',                'state-2', 'number-2'            ]);            $responsible_id = $request->get('responsible_id');            $resp['dateBirth'] = $this->formatDateBD($resp['dateBirth']);            $tag = $this->tag($resp['dateBirth']);            if($tag != 'adult')            {                $request->session()->flash('error.msg', 'Você precisa ser maior de 18 anos, para ser responsável por uma igreja');                return redirect()->back();            }            $resp['role_id'] = $this->responsibleRepository->find($responsible_id)->role_id;            $resp['partner'] = 0;            $resp['imgProfile'] = 'uploads/profile/noimage.png';            $resp["city"] = ucwords($resp["city"]);            $church_id = $request->get('church_id');            $resp['church_id'] = $church_id;            $file = $request->file('img');            $email = $request->get('email');            $person = $this->personRepository->create($resp)->id;            if($person)            {                DB::table('responsibles')                    ->where('id', $responsible_id)                    ->update(['person_id' => $person]);                if($church_array['church_alias'] == "")                {                    $church_array['church_alias'] = $this->churchServices->setChurchAlias($church_array['church_name']);                }                $password = $church_array['church_alias'];                $user = $this->createUserLogin($person, $password, $email, $church_id);                $this->welcome($user, $password);                $this->updateTag($this->tag($resp['dateBirth']), $person, 'people');                if ($file) {                    $this->imgProfile($file, $person, $resp['name'], 'people');                }                $this->newRecentUser($person, $church_id);                session(['church' => $church_id]);                $church['name'] = $church_array['church_name'];                $church['email'] = $email;                $church['tel'] = $church_array['tel'];                $church['cnpj'] = $church_array['cnpj'];                $church['zipCode'] = $church_array['zipCode-2'];                $church['street'] = $church_array['street-2'];                $church['neighborhood'] = $church_array['neighborhood-2'];                $church['city'] = ucwords($church_array['city-2']);                $church['state'] = $church_array['state-2'];                $church['number'] = $church_array['number-2'];                $church['alias'] = $church_array['church_alias'];                $this->repository->update($church, $church_id);                $this->churchServices->setBasicConfig();                auth()->loginUsingId($user->id);            }            DB::commit();            return redirect()->route('index');        }catch(\Exception $e)        {            DB::rollback();            //dd($e);            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente');            return redirect()->back();        }    }    public function transaction(Request $request)    {        $data = $request->except('_token');//dd($data);        try {            $response = (new PagSeguroServices())->request(PagSeguroServices::CHECKOUT_SANDBOX, $data);            //dd($response);        } catch (\Exception $e) {            dd ($e->getMessage());        }    }    public function payment()    {        $data['email'] = 'luiz.sanches8910@gmail.com';        $token = 'B9435321E5E04AD099AB3E714430A8A9';        $data['token'] = $token;        $response = (new PagSeguroServices())->request(PagSeguroServices::SESSION_SANDBOX, $data);        $session = new \SimpleXMLElement($response->getContents());        $session = $session->id;        //$amount = number_format(500, 2, '.', '');        return view('pagseguro', compact('id', 'session', 'token'));    }    public function churchesApi()    {        $list = $this->repository->all(['id', 'name']);        return json_encode($list);    }    public function delete($id)    {        try{            $resp_id = $this->repository->find($id)->responsible_id;            $credit_card = $this->creditCardRepository->findByField('owner_id', $resp_id)->first();            $church = Church::find($id);            $church->responsibles()->detach($resp_id);            if(!$this->responsibleRepository->delete($resp_id))            {                DB::rollback();                return $this->returnFalse('Erro ao excluir usuário responsável');            }            else{                if($this->repository->delete($id))                {                    if(count($credit_card) > 0)                    {                        if(!$this->creditCardRepository->delete($credit_card->id))                        {                            DB::rollback();                            return $this->returnFalse('Erro ao excluir cartão de crédito');                        }                    }                }                else{                    DB::rollback();                    return $this->returnFalse('Erro ao excluir igreja');                }            }            DB::commit();            return json_encode(['status' => true]);        }catch(\Exception $e)        {            DB::rollback();            dd($e);            return $this->returnFalse($e->getMessage());        }    }    public function edit($id)    {        $church = $this->repository->find($id);        $responsible = $this->responsibleRepository->find($church->responsible_id);        $church->sinceOf = date_format($church->created_at, 'd/m/Y');        $person = $this->personRepository->find($responsible->person_id);        $person->dateBirth = isset($person->dateBirth) ? date_format(date_create($person->dateBirth), 'd/m/Y') : null;        return json_encode(            [                'status' => true,                'church' => $church,                'responsible' => $responsible,                'person' => $person            ]        );    }    public function update(Request $request, $id)    {        try{            $data['name'] = $request->get('church_name');            $data['alias'] = $request->get('church_alias');            $data['tel'] = $request->get('tel');            $data['cnpj'] = $request->get('cnpj');            $data['zipCode'] = $request->get('zipCode-2');            $data['street'] = $request->get('street-2');            $data['number'] = $request->get('number-2');            $data['neighborhood'] = $request->get('neighborhood-2');            $data['city'] = $request->get('city-2');            $data['state'] = $request->get('state-2');            $data['email'] = $request->get('email');            $this->repository->update($data, $id);            $church = $this->repository->find($id);            $resp['email'] = $data['email'];            $this->responsibleRepository->update($resp, $church->responsible_id);            $responsible = $this->responsibleRepository->find($church->responsible_id);            $person = $this->personRepository->find($responsible->person_id);            DB::table('people')->where('id', $person->id)->update(['email' => $data['email']]);            DB::table('users')->where('id', $person->user->id)->update(['email' => $data['email']]);            DB::commit();            $request->session()->flash('success.msg', 'A igreja ' . $church->name . ' foi alterado com sucesso');            return redirect()->back();        }catch(\Exception $e){            DB::rollback();            $request->session()->flash('error.msg', 'Mensagem:' . $e->getMessage());            return redirect()->back();        }    }    public function inactive()    {        $churches = Church::onlyTrashed()->paginate(5);        foreach ($churches as $church) {            $church->sinceOf = date_format($church->created_at, 'd/m/Y');        }        $state = $this->stateRepository->all();        return view('site.churches-inactive', compact('churches', 'state'));    }    public function waiting()    {        $churches = Church::where('status', 'waiting')->paginate(5);        foreach ($churches as $church) {            $church->sinceOf = date_format($church->created_at, 'd/m/Y');        }        $state = $this->stateRepository->all();        return view('site.churches-waiting', compact('churches', 'state'));    }    public function activate($id)    {        try{            $church = Church::onlyTrashed()->where('id', $id)->first();            Responsible::onlyTrashed()->where('id', $church->responsible_id)->update(['deleted_at' => null]);            Church::onlyTrashed()->where('id', $id)->update(['deleted_at' => null]);            DB::commit();            return json_encode(['status' => true]);        }catch(\Exception $e)        {            DB::rollback();            return $this->returnFalse($e->getMessage());        }    }    public function fullActivate($id)    {        try{            $data['status'] = 'active';            $this->repository->update($data, $id);            DB::commit();            return json_encode(['status' => true]);        }catch(\Exception $e)        {            DB::rollback();            return $this->returnFalse($e->getMessage());        }    }    public function store(Request $request)    {        $church = $request->except(['responsible_name']);        $resp['name'] = $request->get('responsible_name');        $resp['email'] = $request->get('email');        if(!isset($church['alias']) || $church['alias'] == "")        {            $church['alias'] = $this->churchServices->setChurchAlias($church['name']);        }        $resp_id = $this->responsibleRepository->create($resp)->id;        if($resp_id)        {            $church['responsible_id'] = $resp_id;            $password = $church['alias'];            $church_id = $this->repository->create($church)->id;            if($church_id)            {                session(['church' => $church_id]);                $this->churchServices->setBasicConfig();                $person['name'] = $resp['name'];                $person['church_id'] = $church_id;                $person['role_id'] = $this->roleRepository->findByField('name', 'Administrador')->first()->id;                $person['email'] = $resp['email'];                $person['imgProfile'] = 'uploads/profile/noimage.png';                $person_id = $this->personRepository->create($person)->id;                if($person_id)                {                    $user = $this->createUserLogin($person_id, $password, $person['email'], $church_id);                    $this->welcome($user, $password);                    $resp['person_id'] = $person_id;                    $this->responsibleRepository->update($resp, $resp_id);                    $request->session()->flash('success.msg', 'Os dados foram salvos');                    return redirect()->route('admin.churches');                }                $request->session()->flash('error.msg', 'Erro ao salvar usuário');                return redirect()->route('admin.churches');            }            $request->session()->flash('error.msg', 'Erro ao salvar igreja');            return redirect()->route('admin.churches');        }        $request->session()->flash('error.msg', 'Erro ao salvar responsável');        return redirect()->route('admin.churches');    }}
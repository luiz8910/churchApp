<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Repositories\ChurchRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Services\FeedServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\EmailTrait;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps, UserLoginRepository,
        NotifyRepository, EmailTrait, PeopleTrait, ConfigTrait;

    /**
     * @var PersonRepository
     */
    private $repository;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var FeedServices
     */
    private $feedServices;
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;

    public function __construct(PersonRepository $repository, ChurchRepository $churchRepository, UserRepository $userRepository,
                                FeedServices $feedServices, VisitorRepository $visitorRepository)

    {

        $this->repository = $repository;
        $this->churchRepository = $churchRepository;
        $this->userRepository = $userRepository;
        $this->feedServices = $feedServices;
        $this->visitorRepository = $visitorRepository;
    }




    public function storeApp(Request $request)
    {
        $data = $request->all();

        $church = null; $welcome = null;

        $data['imgProfile'] = isset($data['imgProfile']) ? $data['imgProfile'] :'uploads/profile/noimage.png';

        if($data['maritalStatus'] == 'Casado')
        {
            $data['partner'] = 0;
        }


        if(isset($data['church_id']))
        {
            //Cadastro de Membro

            if($data['church_id'] != "")
            {
                $church = $this->churchRepository->find($data['church_id']);
            }

            //Cadastro de Visitante

            else{

                return $this->storeVisitors($request);
            }
        }
        else{

            //Cadastro de Visitante


            return $this->storeVisitors($request);
        }


        if(!isset($data['name']) || (isset($data['name']) && $data['name'] == ""))
        {
            return $this->returnFalse('Insira o nome');
        }

        if(!isset($data['cel']) || (isset($data['cel']) && $data['cel']) == "")
        {
            return $this->returnFalse('Insira um número de celular');
        }


        $exist_email = count($this->userRepository->findByField('email', $data['email'])) > 0 ? true : false;

        if(isset($data['email']) && $data['email'] != "")
        {

            if($exist_email)
            {
                return $this->returnFalse('Este email já existe na base de dados');
            }

            if(isset($data['dateBirth']))
            {
                if($data['dateBirth'] == '')
                {

                    return $this->returnFalse('Insira a data de Nascimento');

                }else{

                    $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

                    $data['tag'] = $this->tag($data['dateBirth']);

                    $data['role_id'] = 2;

                }

                if($data['role'] == 'Lider' || $data['role'] == 'Administrador')
                {
                    $id = $this->repository->create($data)->id;

                    $welcome = true;

                    $this->newRecentUser($id, $church->id);

                    $this->feedServices->newFeed(5, 'Novo Usuário Cadastrado', $id, null, 'person', $id );
                }
                else{

                    $data['status'] = 'waiting';

                    $id = $this->repository->create($data)->id;

                    $this->feedServices->newFeed(5, 'Novo Usuário Aguardando Aprovação', $id, null, 'person', $id);

                    //Envio Email aguardando aprovação
                    $person = $this->repository->find($id);

                    $this->newWaitingApproval($person, $church->id);
                }

                if($data['tag'] == 'adult')
                {

                    $password = $church->alias;

                    $user = $this->createUserLogin($id, $password, $data['email'], $church->id);

                    if($welcome)
                    {
                        $this->welcome($user, $password);
                    }

                }
            }
        }

        else{

            return $this->returnFalse('Insira um email válido');

        }


        return json_encode(['status' => true]);



    }

    public function storeVisitors(Request $request)
    {
        //return redirect()->route('person.visitors');

        $data = $request->all();

        if(!isset($data['name']) || (isset($data['name']) && $data['name'] == ""))
        {
            return $this->returnFalse('Insira o nome');
        }

        if(!isset($data['cel']) || (isset($data['cel']) && $data['cel']) == "")
        {
            return $this->returnFalse('Insira um número de celular');
        }

        if(isset($data['email']) && $data['email'] != "")
        {
            if(isset($data['dateBirth']))
            {
                if($data['dateBirth'] == '')
                {

                    return $this->returnFalse('Insira a data de Nascimento');

                }else{
                    $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

                    $data['tag'] = $this->tag($data['dateBirth']);

                }

                $id = $this->visitorRepository->create($data)->id;


                if($data['tag'] == 'adult')
                {
                    $user = $this->createUserLogin(null, $data['cel'], $data['email'], null);

                    $this->welcome($user, $data['cel']);
                }
            }
        }

        else{

            return $this->returnFalse('Insira um email válido');

        }


        return json_encode(['status' => true]);

    }

    public function recentPeopleApp($church)
    {

        $people = DB::table('recent_users')
            ->select('person_id')
            ->where('church_id', $church)
            ->get();

        if(count($people) > 0)
        {
            foreach($people as $person)
            {
                $model = $this->repository->find($person->person_id);

                $person->name = $model->name;

                $person->imgProfile = $model->imgProfile;
            }

            return json_encode([
                'status' => true,
                'people' => $people
            ]);
        }

        return json_encode(['status' => false]);
    }


    public function changePassword(Request $request)
    {
        $data = $request->all();

        if(isset($data['person_id']) && $data['person_id'] != "")
        {
            try{
                $pass = bcrypt($data['password']);

                DB::table('users')->
                    where('id', $data['person_id'])->
                    update(['password' => $pass]);

                DB::commit();

                return json_encode(['status' => true]);

            }catch(\Exception $e)
            {
                DB::rollBack();

                return $this->returnFalse($e->getMessage());
            }

        }
        else{

            return $this->returnFalse('Informe a id do usuário');
        }
    }

}

<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Role;
use App\Repositories\ChurchRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Services\FeedServices;
use App\Services\qrServices;
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
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var qrServices
     */
    private $qrServices;

    public function __construct(PersonRepository $repository, ChurchRepository $churchRepository, UserRepository $userRepository,
                                FeedServices $feedServices, VisitorRepository $visitorRepository, RoleRepository $roleRepository,
                                qrServices $qrServices)

    {

        $this->repository = $repository;
        $this->churchRepository = $churchRepository;
        $this->userRepository = $userRepository;
        $this->feedServices = $feedServices;
        $this->visitorRepository = $visitorRepository;
        $this->roleRepository = $roleRepository;
        $this->qrServices = $qrServices;
    }




    public function storeApp(Request $request)
    {
        $data = $request->all();

        if(isset($data['phone'])) {
            $data['tel'] = $data['phone'];
            unset($data['phone']);
        }

        if(isset($data['picture_url'])){

            $data['imgProfile'] = $data['picture_url'];
            unset($data['picture_url']);
        }

        if(isset($data['role'])){
            $data['role_id'] = count($this->roleRepository->findByField('name', $data['role'])->first()->id) > 0
                ? $this->roleRepository->findByField('name', $data['role'])->first()
                : $this->roleRepository->findByField('name', 'Membro')->first()->id;

        }

        if($data['terms'])
        {
            $data['terms'] = 1;
        }

        $church = null;

        $data['imgProfile'] = isset($data['imgProfile']) ? $data['imgProfile'] :'uploads/profile/noimage.png';

        if(isset($data['maritalStatus']))
        {
            if($data['maritalStatus'] == 'Casado')
            {
                $data['partner'] = 0;
            }
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

        /*if(!isset($data['cel']) || (isset($data['cel']) && $data['cel']) == "")
        {
            return $this->returnFalse('Insira um número de celular');
        }*/




        if(isset($data['email']) && $data['email'] != "")
        {
            $user = $this->userRepository->findByField('email', $data['email'])->first();


            if(count($user) > 0)
            {
                if($this->updateSocial($data, $user))
                {
                    return json_encode(['status' => true]);
                }

                return $this->returnFalse('Este email já existe na base de dados');
            }

            if(isset($data['dateBirth']))
            {
                if ($data['dateBirth'] != '' && $data['dateBirth'] != null) {

                    $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

                    $data['tag'] = $this->tag($data['dateBirth']);

                }
            }

                $data['role_id'] = 2;

                $leader = $this->roleRepository->findByField('name', 'Lider')->first()->id;

                $admin = $this->roleRepository->findByField('name', 'Administrador')->first()->id;

                $id = $this->repository->create($data)->id;

                $password = isset($data['password']) ? $data['password'] : $this->randomPassword();

                $this->qrServices->generateQrCode($id);

                $token = null;

                if($request->has('token'))
                {
                    $token = $data['token'];
                }

                $user = $this->createUserLogin($id, $password, $data['email'], $church->id, $token);


                if(($data['role'] == 'Lider' || $data['role'] == 'Administrador') || ($data['role'] == $leader || $data['role'] == $admin))
                {
                    $this->welcome($user, $password);

                    $this->newRecentUser($id, $church->id);

                    $this->feedServices->newFeed(5, 'Novo Usuário Cadastrado', $id, null, 'person', $id );
                }
                else{

                    $data['status'] = 'waiting';

                    $this->repository->update($data, $id);

                    $this->feedServices->newFeed(5, 'Novo Usuário Aguardando Aprovação', $id, null, 'person', $id);

                    //Envio Email aguardando aprovação
                    $person = $this->repository->find($id);

                    $this->newWaitingApproval($person, $church->id);
                }

            }


        else{

            return $this->returnFalse('Insira um email válido');

        }


        return json_encode(['status' => true]);



    }

    public function updateSocial($data, $user)
    {
        if(isset($data['token']) && $data['token'] != '')
        {
            if($user->email == $data['email'])
            {
                $data['role_id'] = 2;

                $password = isset($data['password']) ? $data['password'] : $this->randomPassword();

                $d['password'] = $password;

                $d['social_token'] = $data['token'];

                unset($data['token']);

                unset($data['password']);

                if(isset($data['dateBirth']))
                {
                    if ($data['dateBirth'] != '' && $data['dateBirth'] != null) {

                        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

                        $data['tag'] = $this->tag($data['dateBirth']);
                    }
                }

                $this->repository->update($data, $user->person->id);

                $this->userRepository->update($d, $user->id);

                return true;
            }

            return false;
        }

        return false;
    }


    public function storeAppSocial(Request $request)
    {
        $data = $request->all();

        $data['tel'] = $data['phone'];

        $data['imgProfile'] = $data['picture_url'];

        $data['role_id'] = count($this->roleRepository->findByField('name', $data['role'])->first()->id) > 0 ?
            $this->roleRepository->findByField('name', $data['role'])->first() : $this->roleRepository->findByField('name', 'Membro')->first()->id;

        unset($data['phone']);
        unset($data['picture_url']);
        unset($data['role']);

        $data = new Request($data);

        return $this->storeApp($data);
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
            if(isset($data['password']) && $data['password'] != "")
            {
                try{
                    $pass = bcrypt($data['password']);

                    DB::table('users')
                        ->where('id', $data['person_id'])
                        ->update(['password' => $pass]);

                    DB::commit();

                    return json_encode(['status' => true]);

                }catch(\Exception $e)
                {
                    DB::rollBack();

                    return $this->returnFalse($e->getMessage());
                }
            }
            else{
                return $this->returnFalse('Informe a nova senha');
            }


        }
        else{

            return $this->returnFalse('Informe a id do usuário');
        }
    }


    public function getVisibilityPermissions($person_id)
    {
        $person = $this->repository->findByField('id', $person_id)->first();

        if($person)
        {
            return json_encode(['status' => true, 'value' => $person->visibility]);
        }

        return json_encode(['status' => false, 'msg' => 'Usuário não encontrado']);
    }

    public function changeVisibilityPermissions(Request $request)
    {
        $data = $request->all();

        if(!isset($data['person_id']) || $data['person_id'] == "")
        {
            return json_encode(['status' => false, 'msg' => 'Usuário não encontrado']);

        }else{

            $person = $this->repository->findByField('id', $data['person_id'])->first();

            if(!$person)
            {
                return json_encode(['status' => false, 'msg' => 'Usuário não encontrado']);
            }
        }

        if(!isset($data['value']) || $data['value'] == "")
        {
            return json_encode(['status' => false, 'msg' => 'Campo value não foi definido, valor deve ser 1 ou 0']);
        }

        if(!is_numeric($data['value']))
        {
            return json_encode(['status' => false, 'msg' => 'Campo value deve ser 1 ou 0']);
        }

        if($data['value'] != 0 && $data['value'] != 1)
        {
            return json_encode(['status' => false, 'msg' => 'Campo value deve ser 1 ou 0']);
        }

        $person_id = $data['person_id'];

        $x['visibility'] = $data['value'];

        try{
            DB::beginTransaction();

            if($this->repository->update($x, $person_id))
            {
                DB::commit();

                return json_encode(['status' => true]);
            }
        }catch (\Exception $e){
            DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }


    }

    public function qrcode($id) : bool 
    {
        return $this->qrServices->generateQrCode($id);
    }

}
